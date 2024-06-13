<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //CATEGORIES
        $categories = [
            ['name' => 'Ballad', 'value' => "ballad"],
            ['name' => 'EDM', 'value' => "edm"],
            ['name' => 'Rap', 'value' => "rap"],
            ['name' => 'Pop', 'value' => "pop"],
            ['name' => 'Rock', 'value' => "rock"],
            ['name' => 'R&B', 'value' => "r&b"],
        ];
        DB::table('categories')->insert($categories);
        //SINGERS
        $singers = [
            ['name' => 'Sơn Tùng', 'gender' => 'male'],
            ['name' => 'J97', 'gender' => 'male'],
            ['name' => 'Amee', 'gender' => 'female'],
            ['name' => 'Bích Phương', 'gender' => 'female'],
            ['name' => 'Erik', 'gender' => 'male'],
            ['name' => 'Đông Nhi', 'gender' => 'female'],
            ['name' => 'Min', 'gender' => 'female'],
            ['name' => 'Hồ Quang Hiếu', 'gender' => 'male'],
            ['name' => 'Chi Pu', 'gender' => 'female'],
            ['name' => 'Hiền Hồ', 'gender' => 'female'],
            ['name' => 'Đạt G', 'gender' => 'male'],
            ['name' => 'Bảo Thy', 'gender' => 'female'],
            ['name' => 'Noo Phước Thịnh', 'gender' => 'male'],
            ['name' => 'Binz', 'gender' => 'male'],
            ['name' => 'LK', 'gender' => 'male'],
        ];
        DB::table('singers')->insert($singers);
        //USERS
        $users = [
            ['name' => 'user1', 'email' => 'admin@gmail.com', 'password' => Hash::make('123456'), 'gender' => 'male', 'role' => 'admin'],
            ['name' => 'user1', 'email' => 'user1@gmail.com', 'password' => Hash::make('123456'), 'gender' => 'male', 'role' => 'user'],
            ['name' => 'user2', 'email' => 'user2@gmail.com', 'password' => Hash::make('123456'), 'gender' => 'male', 'role' => 'user'],
            ['name' => 'user3', 'email' => 'user3@gmail.com', 'password' => Hash::make('123456'),  'gender' => 'female', 'role' => 'user'],
            ['name' => 'user4', 'email' => 'user4@gmail.com', 'password' => Hash::make('123456'),  'gender' => 'male', 'role' => 'user'],
            ['name' => 'user5', 'email' => 'user5@gmail.com', 'password' => Hash::make('123456'),  'gender' => 'male', 'role' => 'user'],
        ];
        DB::table('users')->insert($users);
        //ALBUMSs
        $albums = [
            ['name' => 'Acoustic Thư Giản', 'slug' => Str::slug('Acoustic Thư Giản', '-') . '.1', 'description' => 'Không ồn ã, không vội vàng, cùng thư giãn với âm nhạc', 'thumbnail' => 'uploads/thumbnails/c9abead8c0611fc6de38862d135fd7a2.webp'],
            ['name' => 'Chill Hit', 'slug' => Str::slug('Chill Hit', '-') . '.2', 'descripton' => 'Ở đây có những bản hit cực chill, vừa nghe vừa feel', 'thumbnail' => 'uploads/thumbnails/92e34e8a92ba589ba41c078bfbbf57f0.webp'],
            ['name' => 'Vui Vẽ Cuối Tuần', 'slug' => Str::slug('Vui Vẽ Cuối Tuần', '-') . '.3', 'description' => 'Âm nhạc năng lượng dành cho ngày cuối tuần', 'thumbnail' => 'uploads/thumbnails/f2c342c689f75ebe23bfff34745338b8.webp'],
            ['name' => 'Lofi Một Chút Thôi', 'slug' => Str::slug('Lofi Một Chút Thôi', '-') . '.4', 'description' => 'Nhạc Việt "lâu phai" và gây nghiện hoài hoài', 'thumbnail' => 'uploads/thumbnails/24538985249cd4d3b324b4a4a09ad288.webp'],
            ['name' => 'Cuối Tuần Sôi Động', 'slug' => Str::slug('Cuối Tuần Sôi Động', '-') . '.5', 'description' => 'Giải tỏa tinh thần sau 1 tuần căng thẳng bằng những giai điệu', 'thumbnail' => 'uploads/thumbnails/502b17608c88bcd2a85d9fa1821a9898.webp'],
        ];
        DB::table('albums')->insert($albums);
    }
}
