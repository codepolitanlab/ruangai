<?php

namespace Course\Libraries;

use Exception;

class Zoom
{
    private $oauthToken   = ''; // Base64 encoded of clientID:clientSecret
    private $accessToken  = ''; // Retrieved from the Zoom oauth token API
    private $accountID    = '';
    private $clientID     = '';
    private $clientSecret = '';
    public $participants  = [];

    public function __construct()
    {
        $this->accountID    = config('Course')->zoomAccountID;
        $this->clientID     = config('Course')->zoomClientID;
        $this->clientSecret = config('Course')->zoomClientSecret;
    }

    public function getAccessToken()
    {
        // Get access token from cache if not expired yet
        $cache             = service('cache');
        $this->accessToken = $cache->get('zoom_access_token');
        if ($this->accessToken === null) {
            $this->oauthToken = base64_encode($this->clientID . ':' . $this->clientSecret);

            // CURL using guzzleHTTP from https://zoom.us/oauth/token with header Basic $oauthToken
            $url      = 'https://zoom.us/oauth/token';
            $client   = new \GuzzleHttp\Client();
            $response = $client->request('POST', $url, [
                'headers' => [
                    'Content-Type'  => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . $this->oauthToken,
                ],
                'form_params' => [
                    'grant_type' => 'account_credentials',
                    'account_id' => $this->accountID,
                ],
            ]);

            // Check if response valid
            if ($response->getStatusCode() !== 200) {
                return false;
            }

            // Save response to session
            $responseArray     = json_decode($response->getBody()->getContents(), true);
            $this->accessToken = $responseArray['access_token'];

            // Simpan ke cache
            $cache->save('zoom_access_token', $this->accessToken, $responseArray['expires_in']);
        }

        return $this->accessToken;
    }

    public function getParticipantList($zoom_meeting_id, $nextPageToken = null)
    {
        $url = 'https://api.zoom.us/v2/past_meetings/' . $zoom_meeting_id . '/participants?page_size=100';
        if (! empty($nextPageToken)) {
            $url .= '&next_page_token=' . $nextPageToken;
        }

        // CURL using guzzleHTTP with Bearer access token
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ],
        ]);

        // Check if response valid
        if ($response->getStatusCode() === 200) {
            $body = json_decode($response->getBody()->getContents(), true);

            // Pastikan $this->participants adalah array, lalu gabungkan
            if (! isset($this->participants) || ! is_array($this->participants)) {
                $this->participants = [];
            }

            $this->participants = array_merge($this->participants, $body['participants']);

            if ($body['page_count'] > 1 && ! empty($body['next_page_token'])) {
                $this->getParticipantList($zoom_meeting_id, $body['next_page_token']);
            }
        }

        return $this;
    }

    // Accumulate participant duration
    public function accumulateDurations($participants = [])
    {
        $participants ??= $this->participants;

        if (! $participants) {
            throw new Exception('No participants found. Get first using getParticipantList()');
        }

        $leanParticipants = [];

        foreach ($participants as $participant) {
            // Skip in waiting room duration
            if ($participant['status'] === 'in_waiting_room') {
                continue;
            }

            if (! isset($leanParticipants[$participant['user_email']])) {
                $leanParticipants[$participant['user_email']] = 0;
            }
            $leanParticipants[$participant['user_email']] += $participant['duration'];
        }

        return $leanParticipants;
    }

    public function registerToMeeting($email, $name, $zoom_meeting_id)
    {
        $url = 'https://api.zoom.us/v2/meetings/' . $zoom_meeting_id . '/registrants';

        // CURL using guzzleHTTP with Bearer access token to post participant
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ],
            'json' => [
                'email' => $email,
                'first_name' => $name,
            ],
        ]);

        // Check if response valid
        if ($response->getStatusCode() !== 201) {
            throw new Exception('Failed to register to meeting. Status code: ' . $response->getStatusCode());
        }

        // Get registrant_id
        $body = json_decode($response->getBody()->getContents(), true);
        return $body['join_url'];
    }
}
