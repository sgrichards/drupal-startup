# Headings

## How to use

Headings can be referenced in one of two ways:

### Pass a property

For simple headings, you can use the following syntax:

If you want to inherit the context:

```twig
{% render '@heading' with { 'text': 'Hello world'} %}
```

or if you want to use vanilla Twig with no Fractal context inheritence:

```twig
{% include '@heading' with { 'level': 1, 'text': 'Hello world'} %}
```

In both instances, the following HTML will be rendered:

```html
<h1>Hello world</h1>
```

The `include` syntax is likely more useful when creating page templates where
you wanst specific content, whereas `render` is useful when creating content
agnostic molecules or organisms.

### Use as an embed

If you need extra markup in the header, such as links, images, or perhaps even
SVGs you can use the `embed` syntax and override the `content` block:

```twig
{% embed '@heading' %}
  {% block content %}
    Some heading <small>with a little caption</small>
  {% endblock %}
{% endembed %}
```
