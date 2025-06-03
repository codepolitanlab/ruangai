<?= ($result[$config['name']] ?? '') > 0
	? PHP81_BC\strftime("%d %B %Y, %H:%M", strtotime($result[$config['name']]), ci()->config->item('locale'))
	: '-';