<?php
namespace App\Console\Commands\Backoffice;

use Digbang\Security\Contracts\SecurityApi;
use Digbang\Security\Permissions\Permissible;

class UserPermissionAddCommand extends AddPermissionCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backoffice:users:permissions:add {username : The username of the user} {permissions? : A comma-separated list of permissions. If omitted, all permissions will be added.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add permission/s to a backoffice user.';

    /**
     * {@inheritdoc}
     */
    protected function getPermissible(SecurityApi $security)
    {
        $username = $this->argument('username');

        $user = $security->users()->findOneBy(['username' => $username]);
        $this->assertUser($user, "Username [$username] does not exist.");

        return $user;
    }

    /**
     * @param object|null $user
     * @param string      $message
     *
     * @return void
     */
    protected function assertUser($user, $message)
    {
        if (!$user) {
            $this->error($message);

            exit(1);
        }

        if (!$user instanceof Permissible) {
            $this->error('The configured User class needs to extend ' . Permissible::class . ' to use permissions.');

            exit(2);
        }
    }
}
