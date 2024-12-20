import requests
from bs4 import BeautifulSoup as bs
from mysql.connector import connect

resp = requests.get(
    "https://www.modellisimo.ru/shop/legkovye-avtomobili;f_price=MTEwMHwyMzQ3MDB8MQ"
)
html = bs(resp.content, "lxml")

with connect(host="MySQL-8.2", user="root", password="", database="shop") as conn:
    for i, product in enumerate(html.select("div.list-item"), 1):
        link = "https://www.modellisimo.ru" + product.find("a").get("href")
        prod_resp = requests.get(link)
        prod_html = bs(prod_resp.content, "lxml")
        title = prod_html.find("h1", class_="product__title").text.strip()
        brand = prod_html.find("div", class_="brand-info__name").text.strip()
        details = prod_html.find_all("div", class_="details-list__value")
        scale = details[0].text.strip()
        category = details[1].text.strip()
        car_brand = details[2].text.strip()
        year = details[3].text.strip()
        price = (
            prod_html.find("div", class_="block-prices__main")
            .text.strip()
            .replace(" ", "")
        )
        if not year.isnumeric():
            year = "2020"
        country = details[4].text.strip()
        art = prod_html.find("span", id="art_no").text
        img_link = f"https://alfamodeli.ru/photo/{art}.jpg"
        img_resp = requests.get(img_link)
        with open(f"images/{i}.jpg", "wb") as file:
            file.write(img_resp.content)
        print(title, brand, scale, category, car_brand, year, country, img_link, price)
        with conn.cursor() as cursor:
            cursor.execute(
                "INSERT INTO car (title, brand, scale, category, car_brand, year, country, price) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                (title, brand, scale, category, car_brand, year, country, price),
            )
        conn.commit()
