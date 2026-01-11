<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Announcement;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Administrateur PIGIER',
            'email' => 'admin@pigier.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+237 6XX XX XX XX',
        ]);

        // Create Teachers
        $teacher1 = User::create([
            'name' => 'Prof. Jean Dupont',
            'email' => 'jean.dupont@pigier.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'phone' => '+237 6XX XX XX XX',
        ]);

        $teacher2 = User::create([
            'name' => 'Prof. Marie Kamga',
            'email' => 'marie.kamga@pigier.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'phone' => '+237 6XX XX XX XX',
        ]);

        // Create Students
        $student1 = User::create([
            'name' => 'Etudiant Test',
            'email' => 'etudiant@pigier.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'phone' => '+237 6XX XX XX XX',
            'class' => 'Licence 3 Informatique',
            'student_id' => 'PIG2024001',
        ]);

        $student2 = User::create([
            'name' => 'Alice Nkomo',
            'email' => 'alice.nkomo@pigier.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'phone' => '+237 6XX XX XX XX',
            'class' => 'Licence 3 Informatique',
            'student_id' => 'PIG2024002',
        ]);

        // Create Announcements
        Announcement::create([
            'user_id' => $admin->id,
            'title' => 'Bienvenue sur PIGIER School Info',
            'content' => 'Cette plateforme vous permet de recevoir toutes les informations importantes concernant votre scolarité à PIGIER.',
            'type' => 'general',
            'priority' => 'normal',
            'target_audience' => 'all',
            'is_published' => true,
            'published_at' => now(),
        ]);

        Announcement::create([
            'user_id' => $admin->id,
            'title' => 'Changement de salle - Cours de Programmation',
            'content' => 'Le cours de programmation du lundi sera déplacé de la salle B101 vers la salle C205.',
            'type' => 'room_change',
            'priority' => 'urgent',
            'target_audience' => 'Licence 3 Informatique',
            'is_published' => true,
            'published_at' => now(),
        ]);

        // Create Schedules
        Schedule::create([
            'teacher_id' => $teacher1->id,
            'class' => 'Licence 3 Informatique',
            'subject' => 'Programmation Web',
            'room' => 'B101',
            'day' => 'lundi',
            'start_time' => '08:00',
            'end_time' => '10:00',
            'is_active' => true,
        ]);

        Schedule::create([
            'teacher_id' => $teacher2->id,
            'class' => 'Licence 3 Informatique',
            'subject' => 'Base de Données',
            'room' => 'A205',
            'day' => 'mardi',
            'start_time' => '10:00',
            'end_time' => '12:00',
            'is_active' => true,
        ]);

        Schedule::create([
            'teacher_id' => $teacher1->id,
            'class' => 'Licence 3 Informatique',
            'subject' => 'Programmation Mobile',
            'room' => 'B202',
            'day' => 'mercredi',
            'start_time' => '14:00',
            'end_time' => '16:00',
            'is_active' => true,
        ]);

        // Create Grades
        Grade::create([
            'student_id' => $student1->id,
            'teacher_id' => $teacher1->id,
            'subject' => 'Programmation Web',
            'evaluation_type' => 'Devoir',
            'grade' => 15.5,
            'max_grade' => 20,
            'comment' => 'Bon travail, continuez ainsi!',
            'evaluation_date' => now()->subDays(7),
            'is_published' => true,
        ]);

        Grade::create([
            'student_id' => $student1->id,
            'teacher_id' => $teacher2->id,
            'subject' => 'Base de Données',
            'evaluation_type' => 'Examen',
            'grade' => 17,
            'max_grade' => 20,
            'comment' => 'Excellent!',
            'evaluation_date' => now()->subDays(3),
            'is_published' => true,
        ]);

        // Create Payments
        Payment::create([
            'student_id' => $student1->id,
            'amount' => 500000,
            'amount_paid' => 250000,
            'due_date' => now()->addDays(30),
            'status' => 'partial',
            'academic_year' => '2024-2025',
            'payment_type' => 'Scolarité Semestre 1',
        ]);

        Payment::create([
            'student_id' => $student2->id,
            'amount' => 500000,
            'amount_paid' => 500000,
            'due_date' => now()->subDays(10),
            'paid_date' => now()->subDays(15),
            'status' => 'paid',
            'academic_year' => '2024-2025',
            'payment_type' => 'Scolarité Semestre 1',
        ]);
    }
}
