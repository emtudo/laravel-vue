<?php

namespace Emtudo\Domains;

use Emtudo\Domains\Users\User;

abstract class UserModel extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Validate the model, so you will always have a user_id.
     */
    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            if (empty($model->user_id)) {
                $model->setOwnerUser();
                if (empty($model->user_id)) {
                    throw new \InvalidArgumentException(get_class($model).' need to be a valid user_id attribute');
                }
            }
        });
    }

    public function setOwnerUser()
    {
        $user = auth()->user();
        if ($user) {
            $this->user_id = $user->id;
        }
    }
}
