from flask import Flask, jsonify
import os, pymysql

app = Flask(__name__)

def db():
    return pymysql.connect(
        host=os.getenv("MYSQL_HOST"),
        port=int(os.getenv("MYSQL_PORT", "3306")),
        user=os.getenv("MYSQL_USER"),
        password=os.getenv("MYSQL_PASSWORD"),
        database=os.getenv("MYSQL_DATABASE"),
        cursorclass=pymysql.cursors.DictCursor,
    )

@app.get("/ping")
def ping():
    try:
        conn = db()
        with conn.cursor() as cur:
            cur.execute("SELECT 'Flask → Cloudways MySQL ✅' AS msg")
            row = cur.fetchone()
        conn.close()
        return jsonify(row)
    except Exception as e:
        # if anything fails, return error JSON
        return jsonify(error=str(e)), 500

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=8000)
