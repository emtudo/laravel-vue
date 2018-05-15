<?php

namespace Emtudo\Domains\Users\Database\Seeders;

use Emtudo\Domains\Users\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
    }

    public static function start()
    {
        $user = factory(User::class)->create([
          'name' => 'Admin',
          'email' => 'admin@user.com',
          'password' => 'abc123',
          'is_admin' => true,
          'email_confirmed' => true,
      ]);
    }
}
