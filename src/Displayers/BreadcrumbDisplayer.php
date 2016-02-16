<?php

namespace Spatie\Navigation\Displayers;

use Spatie\Navigation\Displayer;
use Spatie\Navigation\Collections\Group;
use Spatie\Navigation\Items\Link;
use Spatie\Navigation\Node;
use Spatie\Navigation\Root;

class BreadcrumbDisplayer implements Displayer
{
    public function display(Root $root) : string
    {
        $startingPoint = $root->filter(function (Node $node) {
            return $node->isActive();
        })[0] ?? null;

        if (empty($startingPoint)) {
            return '';
        }

        return "<ul>{$this->renderNode($startingPoint)}</ul>";
    }

    public function renderNode(Node $node) : string
    {
        if (! $node->isActive()) {
            return '';
        }

        switch (get_class($node)) {

            case Group::class:
                return $this->renderActiveGroup($node);

            case Link::class:
                return $this->renderActiveLink($node);

            default:
                return '';
        }
    }

    public function renderActiveGroup(Group $group) : string
    {
        foreach ($group->children() as $child) {
            if ($child->isActive()) {
                return $this->renderNode($child);
            }
        }

        return '';
    }

    public function renderActiveLink(Link $link) : string
    {
        return "<li><a href=\"{$link->url()}\">{$link->text()}</a></li>";
    }
}
