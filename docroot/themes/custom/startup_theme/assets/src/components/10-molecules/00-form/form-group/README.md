# Form group

This component is to be used for grouping form fields with their labels and
descriptions.

## Usage in Fractal

The component exposes two blocks:

| Block name | Purpose                              |
| ---------- | ------------------------------------ |
| label      | The label element.                   |
| input      | This is a placeholder for the input. |

It also accept a `description` variable. If present, this serves as the
description text the for form element.

### Usage example

```twig
{% extends '@form-group' with { 'description': description } %}
  {% block label %}
    <label for="text-field">I am a form label</label>
  {% endblock%}
  {% block input %}
    <input type="text" id="text-field" name="text-field" />
  {% endblock%}
{% endextends %}
```
