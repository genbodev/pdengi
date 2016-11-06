<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

  public function getAllUsers() {

    $users = User::selectRaw('comments.user_id, name, balance, comments.published_at as date, comments.text as comment')
      ->positiveBalance()
      ->leftJoin('comments', 'users.id', '=', 'comments.user_id')
      ->where('comments.published_at', function($query) {
        $query->selectRaw('max(comments.published_at)')
          ->from('comments')
          ->whereRaw('comments.user_id = users.id');
      })
      ->get();


    return $users;
  }

  public function scopePositiveBalance($query) {
    $query->where('balance', '>', '0');
  }


}
