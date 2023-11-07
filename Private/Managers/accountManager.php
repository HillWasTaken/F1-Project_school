<?php

require_once "Database.php";

// !!! $password is normaal password $passwordhash is beveilig met een hash

//accountManager voor alle functies met accounts te maken

class accountManager
{

    /**
     * @param $email
     * @param $password
     * @return bool|voids
     */
    public static function login($email, $password)
    {
        // global $con staat voor de database$con die nog niet is aangemaakt
        global $con;

        //haal informatie van user op
        $stmt = $con->prepare("SELECT * FROM Users WHERE email=?");
        $stmt->bindvalue(1, $email);

        $stmt->execute();

        $dbuser = $stmt->fetchObject();


        // check eerst of dbuser waar is dus of de select een user heeft meegegeven
        // check daarna of password goed is 
        if ($dbuser !== false) {
            if (password_verify($password, $dbuser->passwordHash)) {

                if ($dbuser->isAdmin == 1) {
                    $_SESSION["isadmin"] = true;
                }
                $_SESSION["login"] = true;
                $_SESSION["userid"] = $dbuser->UserId;

                return true;
            }
        } else {
            return false;
        }
    }


    //functie die nieuwe gebruikers toevoegd
    public static function signup($username, $email, $passwordhash, $country)
    {
        global $con;


        $stmt = $con->prepare("INSERT INTO Users(username, email, passwordHash, isAdmin, isVerified, usercountryId) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bindvalue(1, $username);
        $stmt->bindvalue(2, $email);
        $stmt->bindvalue(3, $passwordhash);
        $stmt->bindvalue(4, 0);
        $stmt->bindvalue(5, 0);
        $stmt->bindvalue(6, $country);

        $stmt->execute();

        //selecteer informatie van net aangemaakte gebruiker
        $stmt = $con->prepare("SELECT * FROM Users WHERE email=?");
        $stmt->bindvalue(1, $email);
        $stmt->execute();
        $dbuser = $stmt->fetchObject();

        //geef sessions mee
        if ($dbuser->isAdmin == 1) {
            $_SESSION["isadmin"] = true;
        }

        $_SESSION["login"] = true;
        $_SESSION["userid"] = $dbuser->UserId;

        return true;
    }


    public static function getName($userid)
    {
        global $con;

        $stmt = $con->prepare("SELECT username FROM Users WHERE UserId=?");
        $stmt->bindValue(1, $userid);
        $stmt->execute();

        if ($dbuser = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $dbuser['username'];
        } else {
            return null;
        }
    }


    public static function getUser($userid)
    {
        global $con;

        $stmt = $con->prepare("SELECT * FROM Users WHERE UserId=?");
        $stmt->bindValue(1, $userid);
        $stmt->execute();

        if ($dbuser = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $dbuser;
        } else {
            return null;
        }


    }


    public static function getAll()
    {
        global $con;

        $stmt = $con->prepare("SELECT * FROM Users");
        $stmt->execute();

        $dbusers = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $dbusers;
    }


    public static function getUserForEdit($userId)
    {
        global $con;

        $stmt = $con->prepare("SELECT username, email, isAdmin, isVerified FROM Users WHERE UserId = ?");
        $stmt->bindValue(1, $userId);
        $stmt->execute();

        $dbuser = $stmt->fetchObject();
        return $dbuser;
    }


    //edit functions
    public static function editUser($username, $email, $isadmin, $isverified, $userId)
    {
        global $con;

        $stmt = $con->prepare("UPDATE users SET username=?, email=?, isAdmin=?, isVerified=? WHERE UserId=?");
        $stmt->bindValue(1, $username);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $isadmin);
        $stmt->bindValue(4, $isverified);
        $stmt->bindValue(5, $userId);
        $stmt->execute();
    }

    public static function editPassword($passwordhash, $userId)
    {
        global $con;

        $stmt = $con->prepare("UPDATE users SET passwordHash=? WHERE UserId=?");
        $stmt->bindValue(1, $passwordhash);
        $stmt->bindValue(2, $userId);
        $stmt->execute();
    }




    public static function editNameEmail($username, $email, $userid, $password)
    {
        global $con;

        $stmt = $con->prepare("UPDATE users SET username=?, email=?, passwordHash=? WHERE UserId=?");
        $stmt->bindValue(1, $username);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $password);
        $stmt->bindValue(4, $userid);


        $stmt->execute();
    }


    //remove functions
    public static function removeUser($removeId)
    {
        global $con;
        $stmt = $con->prepare("DELETE FROM users WHERE UserId = ?");
        $stmt->bindValue(1, $removeId);

        $stmt->execute();
    }


    //upload profile picture
    public static function uploadPP()
    {
        global $con;

        $path = 'includes/ProfilePictures/';
        $file_path = $path . uniqid() . "_" . $_FILES['image']['name'];

        if (move_uploaded_file($_FILES["image"]['tmp_name'], $file_path)) {
            $stmt = $con->prepare("UPDATE Users SET profilePicturePath=? WHERE UserId=?;");
            $stmt->bindValue(1, $file_path);
            $stmt->bindValue(2, $_SESSION["userid"]);
            $stmt->execute();
        }
    }
}




