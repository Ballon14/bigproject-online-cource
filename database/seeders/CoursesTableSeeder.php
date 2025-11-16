<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            [
                'nama_kursus' => 'Data Science Pro',    'biaya' => 1500, 'rating' => 4.7, 'durasi' => 45, 'fleksibilitas' => 5, 'sertifikat' => 5, 'update_terakhir' => 5
            ],[
                'nama_kursus' => 'Web Dev Basic',       'biaya' => 800,  'rating' => 4.5, 'durasi' => 30, 'fleksibilitas' => 4, 'sertifikat' => 4, 'update_terakhir' => 4
            ],[
                'nama_kursus' => 'Digital Marketing',   'biaya' => 1200, 'rating' => 4.6, 'durasi' => 35, 'fleksibilitas' => 5, 'sertifikat' => 5, 'update_terakhir' => 4
            ],[
                'nama_kursus' => 'UI/UX Design',        'biaya' => 1000, 'rating' => 4.4, 'durasi' => 40, 'fleksibilitas' => 4, 'sertifikat' => 4, 'update_terakhir' => 5
            ],[
                'nama_kursus' => 'Python Master',       'biaya' => 900,  'rating' => 4.8, 'durasi' => 38, 'fleksibilitas' => 5, 'sertifikat' => 5, 'update_terakhir' => 5
            ],[
                'nama_kursus' => 'Mobile App Dev',      'biaya' => 1300, 'rating' => 4.3, 'durasi' => 42, 'fleksibilitas' => 4, 'sertifikat' => 4, 'update_terakhir' => 4
            ],[
                'nama_kursus' => 'Cloud Computing',     'biaya' => 1600, 'rating' => 4.5, 'durasi' => 48, 'fleksibilitas' => 5, 'sertifikat' => 5, 'update_terakhir' => 5
            ],[
                'nama_kursus' => 'Graphic Design',      'biaya' => 750,  'rating' => 4.2, 'durasi' => 28, 'fleksibilitas' => 4, 'sertifikat' => 3, 'update_terakhir' => 4
            ],[
                'nama_kursus' => 'Business Analytics',  'biaya' => 1400, 'rating' => 4.7, 'durasi' => 44, 'fleksibilitas' => 5, 'sertifikat' => 5, 'update_terakhir' => 5
            ],[
                'nama_kursus' => 'SEO Specialist',      'biaya' => 950,  'rating' => 4.4, 'durasi' => 32, 'fleksibilitas' => 4, 'sertifikat' => 4, 'update_terakhir' => 4
            ],[
                'nama_kursus' => 'Cyber Security',      'biaya' => 1700, 'rating' => 4.6, 'durasi' => 50, 'fleksibilitas' => 5, 'sertifikat' => 5, 'update_terakhir' => 5
            ],[
                'nama_kursus' => 'Content Writing',     'biaya' => 600,  'rating' => 4.1, 'durasi' => 25, 'fleksibilitas' => 5, 'sertifikat' => 3, 'update_terakhir' => 3
            ],[
                'nama_kursus' => 'Project Management',  'biaya' => 1100, 'rating' => 4.5, 'durasi' => 36, 'fleksibilitas' => 4, 'sertifikat' => 4, 'update_terakhir' => 4
            ],[
                'nama_kursus' => 'AI Fundamentals',     'biaya' => 1250, 'rating' => 4.8, 'durasi' => 46, 'fleksibilitas' => 5, 'sertifikat' => 5, 'update_terakhir' => 5
            ],[
                'nama_kursus' => 'Social Media Marketing','biaya' => 850, 'rating' => 4.3, 'durasi' => 29, 'fleksibilitas' => 4, 'sertifikat' => 4, 'update_terakhir' => 4
            ]
        ]);
    }
}
