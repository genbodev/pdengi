<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class User extends Model {

  public function getAllUsersLastComment() {

//    $users = User::selectRaw('users.id, users.name, users.balance, comments.published_at as date, comments.text as comment')
//      ->positiveBalance()// Убрать, если нужно вывести пользователей с отрицательным балансом
//      ->leftJoin('comments', function ($join) {
//        $join->on('users.id', '=', 'comments.user_id');
//        $join->on('comments.published_at', '=', DB::raw('(select max(comments.published_at) from comments where comments.user_id = users.id)'));
//      })
//      ->orderBy('users.id', 'asc')
//      ->get();
//
//    return $users;

    $users = User::selectRaw('comments.user_id, name, balance, comments.published_at as date, comments.text as comment')
      ->positiveBalance()// Убрать, если нужно вывести пользователей с отрицательным балансом
      ->leftJoin('comments', 'users.id', '=', 'comments.user_id')
      ->where('comments.published_at', function ($query) {
        $query->selectRaw('max(comments.published_at)')
          ->from('comments')
          ->whereRaw('comments.user_id = users.id');
      })
      ->orderBy('users.id', 'asc')
      ->get();

    return $users;
  }

  /**
   * Спрячет пользователей с отрицательным балансом
   * @param $query
   */
  public function scopePositiveBalance($query) {
    $query->where('users.balance', '>=', '0');
  }

  public function sendMoney($sender, $recipient, $sender_sum, $recipient_sum, $add_sum) {

    $new_sender_sum = $sender_sum;
    $new_recipient_sum = $recipient_sum;
    if ($sender !== $recipient) {
      $new_sender_sum = $sender_sum - $add_sum;
      $new_recipient_sum = $recipient_sum + $add_sum;
    }

    DB::table('users')
      ->where('id', $sender)
      ->update(['balance' => $new_sender_sum]);

    DB::table('users')
      ->where('id', $recipient)
      ->update(['balance' => $new_recipient_sum]);

    $comment = 'Перечисленно: ' . $add_sum;

    DB::table('comments')->insert([
      'user_id' => $sender,
      'text' => $comment,
      'published_at' => Carbon::now(),
      'updated_at' => Carbon::now(),
      'created_at' => Carbon::now(),
    ]);

    return array('comment' => $comment, 'date' => Carbon::now()->toDateTimeString(),
                 'new_sender_sum' => $new_sender_sum, 'new_recipient_sum' => $new_recipient_sum);

  }
}
