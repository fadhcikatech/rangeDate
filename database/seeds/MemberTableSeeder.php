<?php

use Illuminate\Database\Seeder;
use App\MemberModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(MemberModel::class,100)->create();
        // // $member = MemberModel::factory(100)->create();
        // factory(App\MemberModel::class, 150)->create()->each(function ($user) {
        //     $user->posts()->save(factory(App\Post::class)->make());
        // });
        DB::table('member_models')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@yahoo.com',
            'phone' => Str::random(10),
            'alamat' => Str::random(10),
            'hobby' => Str::random(10),
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s")    
        ],
    );
    }
}
