# BookGrid

- there is no edit history, last edit wins
- there is no antispam or moderation tools
- you cannot reorder the sections on the same tree level, but you can move them around
- There is a WYSIWYG editor, uploading images as base64 data
- HTML is supported but sanitized

### Installation

- Install PNPM or NPM and composer
- Copy .env.example file to .env and edit it
- `composer install`
- `./artisan migrate`
- `pnpm install`
- `pnpm run build`
- Serve index.php in `public` folder.

### User scenario

1. Register
2. Add a book (form under the book list)
3. Add a section (form under the section list in the "Edit book" page)
4. Edit the section.
5. Register another user - now you can add the first one as a collaborator and vice versa.
6. Click on book title to view the book.
