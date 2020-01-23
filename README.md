# Keep Comments Open

Overrides "Automatically close comments" for specific posts if it's enabled, thereby keeping comments open on them indefinitely.

WordPress comes with the ability to automatically close comments on posts older than a certain number of days, which you
can configure in **Settings > Discussion**. However, its limitation is that there is no way to override this setting for
specific posts that you want to allow comments on indefinitely. This plugin serves to scratch that itch.

Please note that the plugin currently only works with the [Classic Editor](https://wordpress.org/plugins/classic-editor)
as I haven't been able to figure out a way to port it to the Block Editor seamlessly (i.e. without creating an entire
legacy meta box just for one checkbox).

## Installation

1. Extract and upload the `keep-comments-open` directory to `wp-content/plugins`.
2. Activate the plugin — no configuration needed.
3. You may now edit any of your posts to ask WordPress not to automatically close comments on it.

## Frequently Asked Questions

### What happens to my older posts once I activate the plugin?

If WordPress is already closing comments on your older posts, their comments will remain closed until you open them in the post editor and explicitly ask it to keep comments open.

### What happens when I deactivate the plugin?

The original WordPress behavior will be restored — all posts older than your configured number of days will have their comments closed again.

### If I re-enable comments on an older post, then disable comments again, what happens to comments posted in the meantime?

Those comments will remain.