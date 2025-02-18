This is the current database backend for BiblioFiles.

REQUIRED LIB: Flask

Contained is 3 databases (users.csv, books.csv, and ownership.csv):
    - Users organizes the curent created users
    - Books oranganizes the current registered (or imported) books
    - Ownership connects Users and Books
Each databse has its list of keys in the file's first line.
DO NOT edit the data entered in the csv files.

In addition, there are currently 3 pages in the frontend (website)
    - Home page
    - Add User page which adds user data to its databse
    - Add Book page which adds book data to its databse

To run the website locally;
    - run bibliofiles.py
    - open the website printed in the terminal.

- Andre