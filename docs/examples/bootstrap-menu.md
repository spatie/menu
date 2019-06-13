---
title: Bootstrap Menu
weight: 1
---

```php
Menu::new()
    ->addClass('nav navbar-nav')
    ->link('/one', 'One')
    ->link('/two', 'Two')
    ->submenu(
        Link::to('#', 'Dropdown <span class="caret"></span>')
            ->addClass('dropdown-toggle')
            ->setAttributes(['data-toggle' => 'dropdown', 'role' => 'button']),
        Menu::new()
            ->addClass('dropdown-menu')
            ->link('#', 'Action')
            ->link('#', 'Another action')
            ->html('', ['role' => 'separator', 'class' => 'divider'])
    )
    ->wrap('div.collapse.navbar-collapse')
    ->setActive('/one');
```

```html
<ul class="nav navbar-nav">
    <li class="active">
        <a href="/one">One</a>
    </li>
    <li>
        <a href="/two">Two</a>
    </li>
    <li>
        <a href="#" data-toggle="dropdown" role="button" class="dropdown-toggle">
            Dropdown <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li role="separator" class="divider"></li>
        </ul>
    </li>
</ul>
```
