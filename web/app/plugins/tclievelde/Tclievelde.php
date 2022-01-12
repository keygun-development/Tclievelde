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
        $mysqli = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
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
        $user = $mysqli->query("SELECT * FROM wp_users WHERE user_email = '$email'");
        if ($user->num_rows > 0) {
            $user = $user->fetch_assoc();
            return $user;
        } else {
            return 'Er bestaat geen gebruiker met dit emailadres';
        }
    }

    public static function getUser($username, $password)
    {
        $user = wp_authenticate_username_password(null, $username, $password);
        if (!$user->has_errors()) {
            setcookie('user', md5($user->user_login), time() + (86400 * 30), '/');
            header("location: /");
            return $user;
        } else {
            $user = wp_authenticate_email_password(null, $username, $password);
            if ($user->has_errors()) {
                return $user->get_error_message();
            } else {
                setcookie('user', md5($user->user_login), time() + (86400 * 30), '/');
                header("location: /");
                return $user;
            }
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
