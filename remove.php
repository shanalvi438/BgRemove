<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    
    $rand = rand(111111111, 999999999);
    $uploadDirectory = 'upload/';
    $filename = $rand . $_FILES['file']['name'];
    $uploadFilePath = $uploadDirectory . $filename;

   
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)) {
        

       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.remove.bg/v1.0/removebg');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $post = array(
            'image_file' => new CURLFile($uploadFilePath), 
            'size' => 'auto'
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        // Set API key in the request headers
        $headers = array();
        $headers[] = 'X-Api-Key: QY1UKj8iG97Yo8poFiss1LWt'; 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute the API request
        $result = curl_exec($ch);

        // Check for errors and process the response
        if ($result === false) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($status_code === 200) {
                $processedFilePath = 'bg_removs/' . $rand . '.png';
                // Save the processed image
                file_put_contents($processedFilePath, $result);
                echo 'Image saved successfully.';
                echo '<img src="' . $processedFilePath . '" alt="Processed Image">';
            } else {
                echo 'API Error: ' . $result;
            }
        }
        curl_close($ch);
    } else {
        echo 'Error uploading the file.';
    }
    header('Content-Type: application/json');
    echo json_encode(array('success' => true, 'processed_image' => $processedFilePath));
    exit;
}
?>