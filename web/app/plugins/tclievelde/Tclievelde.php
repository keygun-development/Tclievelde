<?php

namespace Tclievelde;

use mysqli;
use mysqli_result;
use Tclievelde\API\Endpoints;
use Tclievelde\core\customTaxonomies\CustomTaxonomyInterface;
use Tclievelde\core\models\ModelInterface;
use WP_Post;
use WP_Query;

/**
 * Class Tclievelde
 * @package Tclievelde
 */
class Tclievelde
{
    /**
     * @var ModelInterface[]
     */
    private static array $matches = [];

    /**
     * @var CustomTaxonomyInterface[]
     */
    private static $custom_taxonomies = [];

    /**
     * @return string
     */
    public static function getDomain(): string
    {
        return "tclievelde";
    }

    /**
     * @param string $post_type
     * @param ModelInterface $model
     */
    public static function setModel(string $post_type, ModelInterface $model)
    {
        self::$matches[$post_type] = $model;
        $model->addActions();
    }

    /**
     * @return mysqli
     */
    public static function dbConnect(): mysqli
    {
        $mysqli = new mysqli('192.168.10.10', $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
        return $mysqli;
    }

    /**
     * @return array|bool|mysqli_result
     */
    public static function getData($query)
    {
        $mysqli = self::dbConnect();
        $result = $mysqli->query($query);
        $mysqli->close();
        if (!$result) {
            return (object)[];
        } else {
            return $result;
        }
    }

    public static function getUserFromEmail($email)
    {
        $mysqli = self::dbConnect();
        $user = $mysqli->query("SELECT * FROM users WHERE email = '$email'");
        if ($user->num_rows > 0) {
            $user = $user->fetch_assoc();
            return $user;
        } else {
            return 'Er bestaat geen gebruiker met dit emailadres';
        }
    }

    public static function getUser($username, $password)
    {
        $mysqli = self::dbConnect();
        $user = $mysqli->query("SELECT * FROM users WHERE email = '$username' AND wachtwoord = '$password'");
        $usern = $mysqli->query("SELECT * FROM users WHERE email = '$username'");
        $passw = $mysqli->query("SELECT * FROM users WHERE wachtwoord = '$password'");
        if ($usern->num_rows == 0) {
            return "Deze gebruiker bestaat niet.";
        } else if ($passw->num_rows == 0) {
            return "Het wachtwoord voor deze gebruiker komt niet overeen";
        }
        if ($user->num_rows > 0) {
            while ($row = $user->fetch_assoc()) {
                $_SESSION['user'] = $row;
                setcookie('user', md5($_SESSION['user']['gebruikersnaam']), time() + (86400 * 30), '/');
                header("location: /");
                exit;
            }
            session_start();
            return $user;
        }
    }

    /**
     * @return bool|mysqli_result
     */
    public static function insertData($query)
    {
        $mysqli = self::dbConnect();
        $result = $mysqli->query($query);
        $mysqli->close();
        return $result;
    }

    /**
     * @param string $taxonomy_type
     * @param CustomTaxonomyInterface $custom_taxonomy
     */
    public static function setCustomTaxonomy(string $taxonomy_type, CustomTaxonomyInterface $custom_taxonomy)
    {
        self::$custom_taxonomies[$taxonomy_type] = $custom_taxonomy;
        $custom_taxonomy->addActions();
    }
}
