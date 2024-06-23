<?php
require_once "BaseDao.php";

class FinalDao extends BaseDao
{

    public function __construct()
    {
        parent::__construct();
    }

    /** TODO
     * Implement DAO method used login user
     */
    public function login($email)
    {
        $stmt = $this->conn->prepare("SELECT email, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function register($data)

    {
        $stmt = $this->conn->prepare("INSERT INTO users(first_name, last_name, email, password) VALUES ( ?, ? , ? , ? )");
        $stmt->execute([$data['first_name'], $data['last_name'], $data['email'], $data['password']]);
        return $this->conn->lastInsertId();
    }


    /** TODO
     * Implement DAO method used add new investor to investor table and cap-table
     */
    public function investor()
    {
    }

    /** TODO
     * Implement DAO method to return list of all share classes from share_classes table
     */
    public function share_classes()
    {
        $stmt = $this->conn->prepare("SELECT * FROM share_classes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** TODO
     * Implement DAO method to return list of all share class categories from share_class_categories table
     */
    public function share_class_categories()
    {
        $stmt = $this->conn->prepare("SELECT * FROM share_class_categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
