<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CzProject\GitPhp\Git;
use CzProject\GitPhp\GitRepository;

class GitPull extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Git';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'git:pull';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Melakukan git pull dari remote repository';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'git:pull [remote] [branch]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $repoPath = realpath('../'); // Ubah ke path yang sesuai (misal root project)
        
        try {
            $git = new Git();
            // create repo object
            $repo = $git->open($repoPath);
            CLI::write("Melakukan git pull untuk branch {$repo->getCurrentBranchName()} di folder: $repoPath", 'yellow');

            $result = $repo->pull([$params[0] ?? 'origin', $params[1] ?? $repo->getCurrentBranchName()]);
            CLI::write("Pull berhasil: \n$result", 'green');
        } catch (\Exception $e) {
            CLI::error("Gagal melakukan git pull: " . $e->getMessage());
        }
    }
}
