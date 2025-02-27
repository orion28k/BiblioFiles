import os
# Flask is base, render_template runs other HTML files
from flask import Flask, request, render_template
from csv import writer, reader

# Create app 
app = Flask(__name__)

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
BOOK_CSV_FILE = os.path.join(BASE_DIR, "databases/books.csv")
BOOK_UPLOAD_FOLDER = os.path.join(BASE_DIR, "uploads")  # Folder to store PDFs
USER_CSV_FILE = os.path.join(BASE_DIR, "databases/users.csv")

# Ensure the upload folder exists
os.makedirs(BOOK_UPLOAD_FOLDER, exist_ok=True)

app.config['UPLOAD_FOLDER'] = BOOK_UPLOAD_FOLDER

# app.route creates the page
# Define function uses html file in /path/templates folder
# Images are pulled from /path/static folder (Refer to the src attribute in the html template)
# Varaibles can be passed after first parameter
@app.route("/")
def default():
    return render_template("home.html")

# user_id, book_name, author_name, genre_name, published_year, page_count, illustration, reading_level, rating_number, location, file
@app.route('/addbook', methods=['GET', 'POST'])
def addbook():
    if request.method == 'POST':
        book_id = 0
        book_name = request.form.get('book_name')
        author_name = request.form.get('author_name')
        genre_name = request.form.get('genre_name')
        published_year = request.form.get('published_year')
        page_count = request.form.get('page_count')
        illustration = None
        reading_level = request.form.get('reading_level')
        rating_number = request.form.get('rating_number')
        location = request.form.get('location')
        link = request.files.get('link')

        # Count row and assign ID
        with open(BOOK_CSV_FILE, 'r') as file:
            read = reader(file)

            row_count = len(list(read))
            book_id = row_count

            file.close()
        
        row = [book_id, book_name, author_name,genre_name,published_year,page_count,illustration,reading_level,rating_number,location,link]

        with open(BOOK_CSV_FILE, 'a') as file:
            # Pass this file object to csv.writer()
            # and get a writer object
            write = writer(file)
        
            # Pass the list as an argument into
            # the writerow()
            write.writerow(row)
        
            # Close the file object
            file.close()

        return f"Book #{book_id} successfully added!"

    return render_template('addbook.html')

@app.route('/adduser', methods=['GET','POST'])
def adduser():
    if request.method == 'POST':
        user_id = 0
        user_name = request.form.get('user_name')
        email = request.form.get('email')
        password = request.form.get('password')

        if(password == "SECRETPASSWORD"):
            is_admin = True
        else:
            is_admin = False

        # Count row and assign ID
        with open(USER_CSV_FILE, 'r') as file:
            read = reader(file)

            row_count = len(list(read))
            user_id = row_count

            file.close()
        
        row = [user_id,user_name,email,password,is_admin]

        with open(USER_CSV_FILE, 'a') as file:
            # Pass this file object to csv.writer()
            # and get a writer object
            write = writer(file)
        
            # Pass the list as an argument into
            # the writerow()
            write.writerow(row)
        
            # Close the file object
            file.close()

        return f"Hello {user_name} and welcome to Biblio Files"
    return render_template('adduser.html')

@app.route('/userprofile', methods=['GET', 'POST'])
def profile():
    return render_template('userprofile.html')

# Runs website on host IP
if __name__ == "__main__":
    app.run()