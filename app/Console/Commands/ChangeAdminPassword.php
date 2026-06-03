<?php

namespace App\Console\Commands;

use App\Services\ContentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ChangeAdminPassword extends Command
{
    protected $signature = 'admin:password {username=admin : The username}';
    protected $description = 'Change admin password';

    public function handle(ContentService $content): int
    {
        $username = $this->argument('username');
        $users = $content->get('users');

        $userIndex = null;
        foreach ($users as $index => $user) {
            if ($user['username'] === $username) {
                $userIndex = $index;
                break;
            }
        }

        if ($userIndex === null) {
            $this->error("User '{$username}' not found!");
            return self::FAILURE;
        }

        $password = $this->secret('New password');
        $confirm = $this->secret('Confirm password');

        if ($password !== $confirm) {
            $this->error('Passwords do not match!');
            return self::FAILURE;
        }

        $users[$userIndex]['password'] = Hash::make($password);
        $content->save('users', $users);

        $this->info("Password for '{$username}' changed successfully!");
        return self::SUCCESS;
    }
}
