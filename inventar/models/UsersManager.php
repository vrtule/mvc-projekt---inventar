<?php
class UsersManager
{
    public function returnHash($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function signUp($name, $email, $password, $passwordAgain) {
        if ($password != $passwordAgain) {
            throw new UserError('Hesla nesouhlasí');
        }
        $user = array(
            'uzivatelske_jmeno' => $name,
            'email' => $email,
            'heslo' => $this->returnHash($password)
        );
        try {
            Db::insert('uzivatele', $user);
        } catch (PDOException $error) {
            throw new UserError('Uživatel s tímto jménem nebo heslem je již zaregistrovaný');
        }

    }

    public function login($name, $password) {
        $user = Db::queryForOne('
        SELECT uzivatele_id, uzivatelske_jmeno, heslo, admin
        FROM uzivatele
        WHERE uzivatelske_jmeno = ?'
        , array($name));

        if (!$user || !password_verify($password, $user['heslo'])) {
            throw new UserError('Neplatné jméno nebo heslo');
        }
        
        $_SESSION['user'] = $user;
    }

    public function signOut() {
        unset($_SESSION['user']);
    }

    public function returnUser() {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        } else {
            return null;
        }
    }

}
