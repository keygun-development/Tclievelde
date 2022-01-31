<?php

namespace functions\customposts;

use Exception;
use functions\core\Proa_Post_Abstract;

class Proa_Reservation extends Proa_Post_Abstract
{
    private string $court = '';
    private string $timeStart = '';
    private string $timeEnd = '';
    private string $id = '';

    /** @var Users[]|null */
    private ?array $relatedPlayers = null;

    private ?array $author = null;

    public function getAuthor(): array
    {
        return $this->author;
    }

    public function getCourt(): string
    {
        return $this->court;
    }

    public function getID(): string
    {
        return $this->id;
    }

    public function getTimeStart(): string
    {
        return $this->timeStart;
    }

    public function getTimeEnd(): string
    {
        return $this->timeEnd;
    }

    public function getRelatedPlayers(): array
    {
        return $this->relatedPlayers;
    }

    public function setAuthor($author): Proa_Reservation
    {
        $this->author = $author;

        return $this;
    }

    public function setCourt($court): Proa_Reservation
    {
        $this->court = $court;

        return $this;
    }

    public function setTimeStart($timeStart): Proa_Reservation
    {
        $this->timeStart = $timeStart;

        return $this;
    }

    public function setTimeEnd($timeEnd): Proa_Reservation
    {
        $this->timeEnd = $timeEnd;

        return $this;
    }

    public function setRelatedPlayers($relatedPlayers): Proa_Reservation
    {
        $this->relatedPlayers = $relatedPlayers;

        return $this;
    }

    public function setID($id): Proa_Reservation
    {
        $this->id = $id;

        return $this;
    }

    public static function getIdentifier(): string
    {
        return 'reservation';
    }

    /**
     * @return Proa_Reservation
     * @throws Exception
     */
    public static function parse($post): self
    {
        $reservation = new Proa_Reservation();

        if ($post->post_type !== 'reservation') {
            throw new Exception('Invalid post type given. Expected reservation.');
        }

        $reservation
            ->setPost($post)
            ->setAuthor(get_field('reservation_author', $post->ID))
            ->setCourt(get_field('reservation_court', $post->ID))
            ->setTimeStart(get_field('reservation_date_time_start', $post->ID))
            ->setTimeEnd(get_field('reservation_time_end', $post->ID))
            ->setRelatedPlayers(get_field('related_player', $post->ID))
            ->setID($post->ID);

        return $reservation;
    }
}
