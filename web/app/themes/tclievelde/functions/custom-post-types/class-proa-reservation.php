<?php

class Proa_Reservation extends Proa_Post
{

	/**
	 * @var string
	 */
	private $title;

	/** @var int */
	private $year;

	/** @var WP_Post[] */
	private $related_techniques;

	/** @var WP_Post[] */
	private $related_dashboards;

	/** @var Proa_Dashboard|null */
	private ?Proa_Dashboard $related_dashboard = null;

	/** @var Proa_Expert */
	private $expert;

	/** @var WP_Post[] */
	private $related_articles;

	/**
	 * @return string
	 */
	public static function getIdentifier(): string
	{
		return 'technique';
	}

	/**
	 * @param  WP_Post  $post
	 *
	 * @return Proa_Technique
	 * @throws Exception
	 */
	public static function parse($post): self
	{
		$technique = new Proa_Technique();
		if ($post->post_type !== 'technique') {
			throw new Exception('Invalid post type given. Expected technique.');
		}

		$technique
            ->setTitle(get_the_title($post))
            ->setYear(get_field('year', $post->ID))
            ->setPost($post)
            ->setRelatedTechniques(get_field('related_techniques', $post->ID))
			->setRelatedDashboards(get_field('related_techniques', $post->ID))
            ->setRelatedArticles(get_field('related_articles', $post->ID))
            ->setRelatedDashboard(get_field('related_dashboard', $post->ID))
            ->setExpert(get_field('expert', $post->ID))
            ->setTechnicalCategories(get_the_terms($post, 'technical-category'));

		return $technique;
	}

	/**
	 * @param  integer  $limit  The maximum amount of participants to return.
	 *
	 * @return Proa_Participant[]|null
	 *
	 * @throws Exception
	 */
	public function getParticipants($limit = 10)
	{
		$participantObjects = [];
		$participants = get_posts(
			[
				'post_type' => 'participant',
				'posts_per_page' => $limit,
				'meta_query' => [
					[
						'key' => 'techniques',
						'value' => '"'.$this->getPost()->ID.'"',
						'compare' => 'LIKE',
					],
				],
			]
		);
		foreach ($participants as $participant) {
			$participantObjects[] = Proa_Participant::parse($participant);
		}
		return $participantObjects;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @param  string  $title
	 *
	 * @return Proa_Technique
	 */
	public function setTitle(string $title): Proa_Technique
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getYear()
	{
		return $this->year;
	}

	/**
	 * @param  mixed  $year
	 *
	 * @return Proa_Technique
	 */
	public function setYear($year)
	{
		$this->year = $year;
		return $this;
	}

	/**
	 * @return Proa_Dashboard[]|Proa_Technique[] Generated array with items of mix Proa_Dashboard / Proa_Technique.
	 * @throws Exception
	 */
	public function getRelatedTechniques(): iterable
	{
		return !empty($this->related_techniques) ? $this->parseRelated() : [];
	}

	/**
	 * @return Proa_Dashboard[]|Proa_Technique[] Generated array with items of mix Proa_Dashboard / Proa_Technique.
	 * @throws Exception
	 */
	public function getRelatedDashboards(): iterable
	{
		return !empty($this->related_dashboards) ? $this->parseRelated() : [];
	}

	/**
	 * @param  WP_Post[]  $related
	 * @return $this
	 * @throws Exception
	 */
	public function setRelatedTechniques($related): self
	{
		$this->related_techniques = $related;
		return $this;
	}

	/**
	 * @param  WP_Post[]  $related
	 * @return $this
	 * @throws Exception
	 */
	public function setRelatedDashboards($related): self
	{
		$this->related_dashboards = $related;
		return $this;
	}

	/**
	 * @return Generator
	 * @throws Exception
	 */
	private function parseRelated(): Generator
	{
		foreach ($this->related_techniques as $post) {
			yield $post->post_type === 'technique' ? Proa_Technique::parse($post) : Proa_Dashboard::parse($post);
		}
	}

	/**
	 * @return null|Proa_Dashboard
	 */
	public function getRelatedDashboard(): ?Proa_Dashboard
	{
		return $this->related_dashboard;
	}

	/**
	 * @param  mixed  $related_dashboard
	 *
	 * @return Proa_Technique
	 * @throws Exception
	 */
	public function setRelatedDashboard($related_dashboard): Proa_Technique
	{
		if ($related_dashboard) {
			$this->related_dashboard = Proa_Dashboard::parse($related_dashboard);
		}
		return $this;
	}

	/**
	 * @param  array  $technical_categories
	 * @return $this
	 * @throws Exception
	 */
	public function setTechnicalCategories($technical_categories): self
	{
		if ($technical_categories) {
			$this->technical_categories = Proa_Technique_Category::parse_many($technical_categories);
		}
		return $this;
	}


	/**
	 * @return Proa_Technique_Category|null
	 */
	public function getTechnicalCategory(): ?Proa_Technique_Category
	{
		return $this->technical_categories[0] ?? null;
	}

	/**
	 * @return array
	 */
	public function getTechnicalCategories(): array
	{
		return $this->technical_categories;
	}

	/**
	 * @return null|iterable
	 */
	public function getRelatedArticles(): iterable
	{
		return !empty($this->related_articles) ? $this->related_articles : [];
	}

	public function setRelatedArticles($result): Proa_Technique
	{
		$this->related_articles = $result;
		return $this;
	}

	/**
	 * @return Proa_Expert|null
	 */
	public function getExpert(): ?Proa_Expert
	{
		return $this->expert;
	}

	/**
	 * @param  mixed  $expert
	 *
	 * @return Proa_Technique
	 * @throws Exception
	 */
	public function setExpert($expert): Proa_Technique
	{
		if ($expert) {
			$this->expert = Proa_Expert::parse($expert);
		}
		return $this;
	}
}
