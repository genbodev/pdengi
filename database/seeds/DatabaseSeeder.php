<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    Model::unguard();

    // $this->call('UserTableSeeder');
    $this->call('UsersSeeder');
    $this->call('CommentsSeeder');
  }

}

class UsersSeeder extends Seeder {
  public function run() {
    DB::table('users')->delete();
    User::create([
      'name' => 'Иванов Иван Иванович',
      'balance' => '5000.99',
      'published_at' => DB::raw('DATE_SUB(CURDATE(), Interval 1 MONTH)')
    ]);

    User::create([
      'name' => 'Петров Петр Петрович',
      'balance' => '4000.99',
      'published_at' => DB::raw('DATE_SUB(CURDATE(), Interval 1 MONTH)')
    ]);

    User::create([
      'name' => 'Алексеев Алексей Алексеевич',
      'balance' => '3000.99',
      'published_at' => DB::raw('DATE_SUB(CURDATE(), Interval 1 MONTH)')
    ]);
  }
}

class CommentsSeeder extends Seeder {
  public function run() {
    DB::table('comments')->delete();

    $date = Carbon::now();

    Comment::create([
      'user_id' => '1',
      'text' => 'Комментарий 1 (user_id_1)',
      'published_at' => $date->subDays(1)
    ]);
    Comment::create([
      'user_id' => '2',
      'text' => 'Комментарий 1 (user_id_2)',
      'published_at' => $date->subDays(1)
    ]);
    Comment::create([
      'user_id' => '3',
      'text' => 'Комментарий 1 (user_id_3)',
      'published_at' => $date->subDays(1)
    ]);
    Comment::create([
      'user_id' => '1',
      'text' => 'Комментарий 2 (user_id_1)',
      'published_at' => $date->subDays(1)
    ]);
    Comment::create([
      'user_id' => '2',
      'text' => 'Комментарий 2 (user_id_2)',
      'published_at' => $date->subDays(1)
    ]);
    Comment::create([
      'user_id' => '3',
      'text' => 'Комментарий 2 (user_id_3)',
      'published_at' => $date->subDays(1)
    ]);
    Comment::create([
      'user_id' => '1',
      'text' => 'Комментарий 3 (user_id_1)',
      'published_at' => $date->subDays(1)
    ]);
    Comment::create([
      'user_id' => '2',
      'text' => 'Комментарий 3 (user_id_2)',
      'published_at' => $date->subDays(1)
    ]);
    Comment::create([
      'user_id' => '3',
      'text' => 'Комментарий 3 (user_id_3)',
      'published_at' => $date->subDays(1)
    ]);
  }
}
