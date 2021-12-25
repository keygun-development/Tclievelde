<?php

namespace Tclievelde\Theme\TemplateParts\Nav;

use Tclievelde\helpers\DisplaysView;
use Tclievelde\helpers\NewExpression;

class Navigation
{
    use NewExpression,
        DisplaysView;

    /**
     * @var array
     */
    private array $items = [];

    /**
     * @var string
     */
    private string $start;
    private string $end;
    private string $itemView;

    /**
     * @param array $items
     *
     * @return $this
     */
    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function getStartView(): string
    {
        return $this->start;
    }

    /**
     * @return string
     */
    public function getEndView(): string
    {
        return $this->start;
    }

    /**
     * @param $item
     *
     * @return string
     */
    public function getItemView($item): string
    {
        return $this->itemView;
    }

    /**
     * @param string $itemView
     *
     * @return Navigation
     */
    public function setItemView(string $itemView): self
    {
        $this->itemView = $itemView;

        return $this;
    }

    /**
     * @return string
     */
    public function getItemsView(): string
    {
        $output = '';

        foreach ($this->getItems() as $item) {
            $output .=$this->getItemView($item);
        }

        return $output;
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        $output = $this->getStartView();

        $output .= $this->getItemsView();

        $output .= $this->getEndView();


        return $output;
    }
}
