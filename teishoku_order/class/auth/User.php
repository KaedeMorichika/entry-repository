<?php


namespace auth;

use auth\SingletonPDO;

class User
{
    private int $id;
    private string $name;
    private string $user_id;
    private string $password;
    private int $created;
    private int $updated;

    /**
     * ユーザーログイン処理
     * @param string $user_id
     * @param string $password
     * @return User|bool
     */
    public static function login(string $user_id, string $password)
    {
        try {

            $dbh = SingletonPDO::connect();

            $sql = 'SELECT * FROM user WHERE user_id = :user_id';

            $param = [
                'user_id' => $user_id,
            ];

            $stmt = $dbh->prepare($sql);
            $stmt->execute($param);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, get_class());

            $user = $stmt->fetch(); /* @var $user User|bool */

            if ( empty($user) || ! password_verify($password, $user->getPassword()) ) {
                return false;
            }

            return $user;

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * IDからユーザーのインスタンスを取得
     * @param int $id
     * @return User|bool
     */
    public static function getById(int $id)
    {
        try {

            $dbh = SingletonPDO::connect();

            $sql = '
            SELECT * FROM user 
            WHERE id = :id
            ';

            $param = [
                'id' => $id
            ];

            $stmt = $dbh->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, get_class());
            return $stmt->fetch();

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getCreated(): int
    {
        return $this->created;
    }

    /**
     * @return int
     */
    public function getUpdated(): int
    {
        return $this->updated;
    }

}