<?php

/**
 * Notification class
 */
class Notification
{
    public function sendEmailNotification($firstName, $lastName, $username, $password)
    {
        $url = "Your google gmail app url";
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTFIELDS => http_build_query([
                "recipient" => $username,
                "subject"   => "STCMS User Credentials",
                "body"      => "Dear: " . $firstName . " " . $lastName . " welcome to STCMWA\nYour username: " . $username . "\nYour password: " . $password . "\nYou can now log in using your username and password."
            ])
        ]);
        $result = curl_exec($ch);
        return $result;
    }

    public function sendPaymentEmailNotification($firstName, $lastName, $username, $course, $courseCode, $courseCost, $amountPaid, $restPayment)
    {
        $url = "Your google gmail app url";
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTFIELDS => http_build_query([
                "recipient" => $username,
                "subject"   => "STCMS Course Payment",
                "body"      => "Dear: " . $firstName . " " . $lastName . "\nBelow is the payment details for course: " . $course . "\n\nCourse code: " . $courseCode . "\nCourse Cost: " . $courseCost . "\nAmount you have paid: " . $amountPaid . "\nAmount rest to pay: " . $restPayment . "\nThank you for your course payment."
            ])
        ]);
        $result = curl_exec($ch);
        return $result;
    }

    public function sendPaymentNotification($firstName, $lastName, $username, $course, $courseCode, $courseCost, $amountPaid, $restPayment)
    {
        $url = "Your google gmail app url";
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTFIELDS => http_build_query([
                "recipient" => $username,
                "subject"   => "STCMS Course Payment Reminder",
                "body"      => "Dear: " . $firstName . " " . $lastName . "\nWe are remebering you that there are money that are not paid for the course: " . $course . "\n With course code: " . $courseCode . "\nAnd course Cost: " . $courseCost . ",\nAmount that you had paid: " . $amountPaid . "\nAnd the amount rest to pay: " . $restPayment . "\nThank you and have a nice day."
            ])
        ]);
        $result = curl_exec($ch);
        return $result;
    }
}
