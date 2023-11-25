<?php
/*
Plugin Name: ChatGPT Plugin
Description: Plugin para integrar la API de ChatGPT en WordPress[chatgpt_form] copia y pega
Version: 1.0
Author: ai dev 
*/

function chatgpt_form_shortcode() {
    ob_start(); ?>
    <style>
        /* Estilos para el formulario */
        #chatgpt-form-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #f8f9fa;
            text-align: center;
        }

        #user_question {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 16px;
        }

        #submit_question {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        #submit_question:hover {
            background-color: #0056b3;
        }

        /* Estilos para la respuesta de ChatGPT */
        #chatgpt_response_container {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f8f9fa;
            text-align: left;
        }

        #chatgpt_response {
            white-space: pre-line;
            font-size: 16px;
        }
    </style>

    <div id="chatgpt-form-container">
        <label for="user_question">Haz tu pregunta:</label>
        <input type="text" id="user_question" name="user_question">
        <button id="submit_question">Enviar</button>
    </div>

    <div id="chatgpt_response_container" class="mt-3">
        <strong>Respuesta de ChatGPT:</strong>
        <div id="chatgpt_response"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const submitButton = document.getElementById('submit_question');
            const responseDiv = document.getElementById('chatgpt_response');
            const questionInput = document.getElementById('user_question');

            submitButton.addEventListener('click', function () {
                const userQuestion = questionInput.value;

                // Realiza la solicitud a la API de ChatGPT
                fetch('https://api.openai.com/v1/chat/completions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer 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',
                    },
           body: JSON.stringify({
                        model: 'gpt-3.5-turbo',
                        messages: [
                            { role: 'system', content: 'You are a helpful assistant.' },
                            { role: 'user', content: userQuestion },
                        ],
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    // Muestra la respuesta en el div de respuesta
                    responseDiv.innerHTML = 'Respuesta de ChatGPT: ' + data.choices[0].message.content;
                })
                .catch(error => {
                    console.error('Error al realizar la solicitud a la API de ChatGPT:', error);
                    responseDiv.innerHTML = 'Hubo un error al procesar la pregunta.';
                });
            });
        });
    </script>
    <?php
    return ob_get_clean();
}

add_shortcode('chatgpt_form', 'chatgpt_form_shortcode');








