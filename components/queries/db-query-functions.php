<?php
include QUERIES_PATH . "db-queries.php";
function verifyCompany($name, $code, $conn)
{
    global $verify_company;
    $stmt = $conn->prepare($verify_company);
    $stmt->bind_param("ss", $name, $code);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows > 0)
    {
        return $result->fetch_assoc()['company_id'];
    }
    return false;
}
function getCompanies($conn)
{
    global $get_companies;
    $stmt = $conn->prepare($get_companies);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $companies = [];
    while ($row = $result->fetch_assoc())
    {
        array_push($companies, $row['company_name']);
    }
    return $companies;
}
function registerUser($data, $conn, $c_id)
{
    global $register_user;
    $stmt = $conn->prepare($register_user);
    $hash = password_hash($data['pass'], PASSWORD_DEFAULT);
    $fullName = $data['fname'] . " " . $data['lname'];
    $stmt->bind_param("ssssi", $data['uname'], $data['email'], $fullName, $hash, $c_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0)
    {
        return true;
    }
    $stmt->close();
    return false;
}
function findEmail($email, $conn)
{
    global $get_email;
    $stmt = $conn->prepare($get_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows > 0)
    {
        return true;
    }
    return false;
}
function findUser($user, $conn)
{
    global $get_user;
    $stmt = $conn->prepare($get_user);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows > 0)
    {
        return true;
    }
    return false;
}
function loginUser($data, $conn)
{
    global $post_login;
    $stmt = $conn->prepare($post_login);
    $stmt->bind_param("s", $data['l_uname']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows > 0)
    {
        $hash = $result->fetch_assoc()['password_hash'];
        if (password_verify($data['l_pass'], $hash))
        {
            return true;
        }
    }
    return false;
}
function getUser($user, $conn)
{
    global $get_user_details;
    $stmt = $conn->prepare($get_user_details);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows > 0)
    {
        return $result->fetch_assoc();
    }
    return false;
}
?>