<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Admin\Admin;
use App\Models\Member\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property int id
 * @property string username
 * @property string email
 * @property string email_verified_at
 * @property string password
 * @property string remember_token
 * @property int user_type
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Admin admin
 * @property Member member
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    const USER_TYPE_MEMBER = 1;

    const USER_TYPE_PLATFORM_MANAGER = 100;

    const USER_TYPE_PLATFORM_SUPER_MANAGER = 999;

    /**
     * 模型日期列的存储格式
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin(){
        return $this->hasOne(Admin::class,'created_by','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function member(){
        return $this->hasOne(Member::class,'created_by','id');
    }

    /**
     * @return bool
     */
    public function isMember()
    {
        return self::USER_TYPE_MEMBER === $this->user_type;
    }

    /**
     * @return bool
     */
    public function isManager()
    {
        return self::USER_TYPE_PLATFORM_MANAGER === $this->user_type;
    }

    /**
     * @return bool
     */
    public function isSuperManager()
    {
        return self::USER_TYPE_PLATFORM_SUPER_MANAGER === $this->user_type;
    }

    /**
     * @param $password
     * @return bool
     */
    public function resetPassword($password){
        $this->password = bcrypt($password);
        return $this->save();
    }

    /**
     * @return string|null
     */
    public function getMemberID(){
        if (!empty($this->member)){
            return $this->member->id;
        }
        return null;
    }

    /**
     * @param $param
     * @param $role_type
     * @return bool
     */
    public function register($param, $role_type)
    {
        $param['email'] = "{$param['username']}@hcplatform.com";
        $param['password'] = bcrypt($param['password']);
        $param['user_type'] = $role_type;
        return $this->fill($param)->save();
    }

    /**
     * @param $param
     * @return bool
     */
    public function registerManager($param)
    {
        return $this->register($param, self::USER_TYPE_PLATFORM_MANAGER);
    }

    /**
     * @param $param
     * @return bool
     */
    public function registerMember($param)
    {
        return $this->register($param, self::USER_TYPE_MEMBER);
    }

    /**
     * @param $id
     * @param $with
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null|static
     */
    static function findOneByID($id, $with = [])
    {
        return self::query()->where('id', $id)->with($with)->first();
    }
}
