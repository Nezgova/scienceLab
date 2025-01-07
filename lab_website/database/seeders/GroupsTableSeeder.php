<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;
class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    

public function run()
{
    Group::create(['name' => 'Artificial Intelligence Lab', 'description' => 'Research in AI and machine learning.']);
    Group::create(['name' => 'Bioinformatics Lab', 'description' => 'Research in computational biology.']);
    Group::create(['name' => 'Robotics Lab', 'description' => 'Research in robotics and automation.']);
}

}
