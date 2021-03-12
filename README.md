# Unregister Broken Patterns

Unregister block patterns that contain block types not available to the editor.

### Details

It is possible to restrict block types from being used in the editor with the `allowed_block_types` filter. It is also possible
to unregister block types entirely.

By default, the pattern library in the block editor will continue to to show patterns that contain unavailable blocks. If someone
attempts to insert one of these patterns, nothing happens.

This plugin attempts to remove any patterns with unavailable blocks. It will currently only operate with block types and patterns
that are registered via PHP. This plugin will not be necessary once [Gutenberg issue 23275](https://github.com/WordPress/gutenberg/issues/23275)
and others like it are resolved with (very likely) a better long-term solution that can account for PHP and JavaScript.

### What about JavaScript?

If you have ideas on how to approach this in JavaScript, feel free to comment on the open issue!
