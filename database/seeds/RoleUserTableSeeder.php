<?php

use App\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        User::findOrFail(1)->roles()->sync(1);
        foreach(range(2,4) as $id)
        {
            User::findOrFail($id)->roles()->sync(2);
        }
    }
}
