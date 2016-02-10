<?php

namespace Spatie\Navigation\Displayers;

use Spatie\Navigation\Displayer;
use Spatie\Navigation\Group as GroupInterface;
use Spatie\Navigation\Groups\Group;
use Spatie\Navigation\Items\Link;
use Spatie\Navigation\Node;

class MenuDisplayer implements Displayer
{
    public function display(Node $node) : string
    {
        if (! $node instanceof GroupInterface) {
            $node = new Group($node);
        }

        return $this->renderGroupContents($node);
    }

    protected function renderNode(Node $node) : string
    {
        switch (get_class($node)) {

            case Group::class:
                return $this->renderGroup($node);

            case Link::class:
                return $this->renderLink($node);

            default:
                return '';
        }
    }

    protected function renderGroup(Group $group) : string
    {
        $attributes = $group->isActive() ? 'class="active"' : '';

        return "<li{$attributes}>{$this->renderGroupContents($group)}</li>";
    }

    protected function renderGroupContents(Group $group) : string
    {
        return '<ul>'.implode('', $group->map(function (Node $node) {
            return $this->renderNode($node);
        })).'</ul>';
    }

    protected function renderLink(Link $link) : string
    {
        $attributes = $link->isActive() ? ' class="active"' : '';

        return "<li{$attributes}><a href=\"{$link->url()}\">{$link->text()}</a></li>";
    }
}
