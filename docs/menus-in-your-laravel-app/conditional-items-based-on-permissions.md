---
title: Conditional Items Based on Permissions
weight: 3
---

<span class="badge">v1.1+</span>

The `add` method and all convenience methods (`link`, `html`, `action`,...) have an equivalent method with an `IfCan` suffix. When used, the item will only be added if the currently logged in user has a certain permission.

```php
Menu::new()
    ->link('/', 'Home')
    ->linkIfCan('view-posts', '/posts', 'Posts');
```

```html
<!-- User isn't logged in or can't view posts -->
<ul>
    <li><a href="/">Home</a></li>
</ul>
```

```html
<!-- User is logged in and can view posts -->
<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/posts">Posts</a></li>
</ul>
```

If your permission check requires parameters, you can provide an array for the permission. The permission's name should be the first element, and parameters should fill up the rest.

```php
Menu::new()
    ->link('PostController@show', 'View post')
    ->linkIfCan(['edit-post', $post], 'PostController@edit', 'Edit post');
```

```html
<!-- User isn't logged in or can't edit the post -->
<ul>
    <li><a href="/posts/1">View post</a></li>
</ul>
```

```html
<!-- User is logged in and can edit the post -->
<ul>
    <li><a href="/posts/1">View post</a></li>
    <li><a href="/posts/1/edit">Edit post</a></li>
</ul>
```
