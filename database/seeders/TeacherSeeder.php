<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $teachers = [
            'Madam Diana',
            'Mr Lewis',
            'Mr Victor',
            'Mr Obi',
            'Madam Gladis',
            'Madam Ruth',
            'Madam Maurine',
            'Madam Kelly',
            'Madam Geilien',
            'Madam Loris',
            'Madam Franch',
        ];

        foreach ($teachers as $name) {
            Teacher::firstOrCreate(['name' => $name], ['is_active' => true, 'has_voted' => false]);
        }
    }
}
