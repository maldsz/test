<?php
class UserSettings
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function updateSettings($user_id, $theme, $profile_image)
    {
        $sql = "SELECT * FROM user_settings WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $sql = "UPDATE user_settings SET theme = ?, profile_image = ? WHERE user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ssi', $theme, $profile_image, $user_id);
        } else {
            $sql = "INSERT INTO user_settings (user_id, theme, profile_image) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('iss', $user_id, $theme, $profile_image);
        }

        return $stmt->execute();
    }

    public function getUserSettings($user_id)
    {
        $sql = "SELECT theme, profile_image FROM user_settings WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}
