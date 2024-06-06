from flask import Flask, request, render_template, redirect, url_for, session
from werkzeug.security import generate_password_hash, check_password_hash
import mysql.connector
import os

app = Flask(__name__)
app.config['SECRET_KEY'] = 'Consuelo'
app.config['UPLOAD_FOLDER'] = 'uploads'

# Configuração do MySQL
db_config = {
    'user': 'your_mysql_username',
    'password': 'your_mysql_password',
    'host': 'localhost',
    'database': 'video_platform'
}

def get_db_connection():
    conn = mysql.connector.connect(**db_config)
    return conn

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']
        conn = get_db_connection()
        cursor = conn.cursor(dictionary=True)
        cursor.execute("SELECT * FROM users WHERE username = %s", (username,))
        user = cursor.fetchone()
        cursor.close()
        conn.close()
        if user and check_password_hash(user['password'], password):
            session['user_id'] = user['id']
            return redirect(url_for('index'))  # Redireciona para a página principal
        else:
            return 'Credenciais incorretas!'
    return render_template('login.html')

@app.route('/logout')
def logout():
    session.pop('user_id', None)
    return redirect(url_for('index'))

@app.route('/')
def index():
    if 'user_id' in session:
        return render_template('index.html')
    else:
        return redirect(url_for('login'))  # Redireciona para a página de login se o usuário não estiver logado

@app.route('/upload', methods=['GET', 'POST'])
def upload():
    if request.method == 'POST':
        title = request.form['title']
        description = request.form['description']
        video = request.files['video']
        if video:
            filename = video.filename
            video.save(os.path.join(app.config['UPLOAD_FOLDER'], filename))
            conn = get_db_connection()
            cursor = conn.cursor()
            cursor.execute(
                "INSERT INTO videos (user_id, title, description, filename) VALUES (%s, %s, %s, %s)",
                (1, title, description, filename)
            )
            conn.commit()
            cursor.close()
            conn.close()
            return redirect(url_for('index'))
    return render_template('upload.html')

@app.route('/videos')
def videos():
    conn = get_db_connection()
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM videos")
    videos = cursor.fetchall()
    cursor.close()
    conn.close()
    return render_template('videos.html', videos=videos)

@app.route('/videos/<filename>')
def video(filename):
    return render_template('video.html', filename=filename)

if __name__ == '__main__':
    app.run(debug=True)
