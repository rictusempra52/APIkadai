<!-- mermaid記法によるER図 -->

```mermaid
erDiagram

users ||--o{ inquiries : "投稿する"
users ||--o{ user_type_master : "ユーザー種別"

users {
    int id PK
    string email
    string  password
    int user_type
    string building_id FK
    string room_id FK
    datetime created_at
    datetime updated_at
    datetime deleted_at
}

inquiries {
    int id PK
    int user_id FK
    string inquiry
    int status
    datetime deadline
    datetime finished_at
    datetime created_at
    datetime updated_at
    datetime deleted_at
}

user_type_master {
    int id PK
    string name
}
```
