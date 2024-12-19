<?php
header('Content-Type: application/json');

// Array of polls with questions and options
$polls = [
    [
        "question" => "What's your favorite way to stay active?",
        "option-1" => "Running",
        "option-2" => "Yoga",
        "option-3" => "Weightlifting",
        "option-4" => "Dancing"
    ],
    [
        "question" => "What's your preferred type of cuisine?",
        "option-1" => "Italian",
        "option-2" => "Mexican",
        "option-3" => "Chinese",
        "option-4" => "Indian"
    ],
    [
        "question" => "How do you prefer to communicate?",
        "option-1" => "Texting",
        "option-2" => "Calling",
        "option-3" => "Video chat",
        "option-4" => "In person"
    ],
    [
        "question" => "What's your ideal weekend activity?",
        "option-1" => "Going to the movies",
        "option-2" => "Hiking in nature",
        "option-3" => "Visiting friends",
        "option-4" => "Staying home"
    ],
    [
        "question" => "What's your favorite type of movie?",
        "option-1" => "Action",
        "option-2" => "Comedy",
        "option-3" => "Drama",
        "option-4" => "Horror"
    ],
    [
        "question" => "How do you like to unwind after a long day?",
        "option-1" => "Reading a book",
        "option-2" => "Watching TV",
        "option-3" => "Taking a bath",
        "option-4" => "Going for a walk"
    ],
    [
        "question" => "What's your dream job?",
        "option-1" => "Artist",
        "option-2" => "Scientist",
        "option-3" => "Travel Blogger",
        "option-4" => "Tech Innovator"
    ],
    [
        "question" => "Which social media platform do you use the most?",
        "option-1" => "Facebook",
        "option-2" => "Instagram",
        "option-3" => "Twitter",
        "option-4" => "TikTok"
    ],
    [
        "question" => "How do you feel about pineapple on pizza?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not for me",
        "option-4" => "Absolutely not!"
    ],
    [
        "question" => "What's your favorite outdoor activity?",
        "option-1" => "Camping",
        "option-2" => "Fishing",
        "option-3" => "Biking",
        "option-4" => "Picnicking"
    ],
    [
        "question" => "Which animal would you like as a pet?",
        "option-1" => "Dog",
        "option-2" => "Cat",
        "option-3" => "Fish",
        "option-4" => "Rabbit"
    ],
    [
        "question" => "What type of book do you enjoy reading?",
        "option-1" => "Fiction",
        "option-2" => "Non-fiction",
        "option-3" => "Mystery",
        "option-4" => "Fantasy"
    ],
    [
        "question" => "What's your favorite pizza topping?",
        "option-1" => "Cheese",
        "option-2" => "Pepperoni",
        "option-3" => "Vegetable",
        "option-4" => "Pineapple"
    ],
    [
        "question" => "How do you prefer to travel?",
        "option-1" => "By car",
        "option-2" => "By plane",
        "option-3" => "By train",
        "option-4" => "By bike"
    ],
    [
        "question" => "What's your favorite type of weather?",
        "option-1" => "Sunny",
        "option-2" => "Rainy",
        "option-3" => "Snowy",
        "option-4" => "Windy"
    ],
    [
        "question" => "What's your favorite dessert?",
        "option-1" => "Ice cream",
        "option-2" => "Cake",
        "option-3" => "Cookies",
        "option-4" => "Brownies"
    ],
    [
        "question" => "Which superhero do you admire the most?",
        "option-1" => "Spider-Man",
        "option-2" => "Wonder Woman",
        "option-3" => "Batman",
        "option-4" => "Iron Man"
    ],
    [
        "question" => "What's your favorite video game genre?",
        "option-1" => "RPG",
        "option-2" => "Action",
        "option-3" => "Puzzle",
        "option-4" => "Sports"
    ],
    [
        "question" => "What's your preferred method of studying?",
        "option-1" => "Flashcards",
        "option-2" => "Group study",
        "option-3" => "Online courses",
        "option-4" => "Reading textbooks"
    ],
    [
        "question" => "What's your favorite board game?",
        "option-1" => "Monopoly",
        "option-2" => "Scrabble",
        "option-3" => "Chess",
        "option-4" => "Settlers of Catan"
    ],
    [
        "question" => "How do you like your coffee?",
        "option-1" => "Black",
        "option-2" => "With cream and sugar",
        "option-3" => "I don't drink coffee",
        "option-4" => "I prefer tea"
    ],
    [
        "question" => "What's your favorite holiday?",
        "option-1" => "Christmas",
        "option-2" => "Halloween",
        "option-3" => "Thanksgiving",
        "option-4" => "New Year's"
    ],
    [
        "question" => "Which fruit do you prefer?",
        "option-1" => "Apple",
        "option-2" => "Banana",
        "option-3" => "Orange",
        "option-4" => "Grapes"
    ],
    [
        "question" => "How do you feel about video game remakes?",
        "option-1" => "Love them!",
        "option-2" => "They can be good",
        "option-3" => "Not necessary",
        "option-4" => "I prefer originals"
    ],
    [
        "question" => "Which of these TV shows do you enjoy the most?",
        "option-1" => "Game of Thrones",
        "option-2" => "Friends",
        "option-3" => "The Office",
        "option-4" => "Breaking Bad"
    ],
    [
        "question" => "What's your go-to comfort food?",
        "option-1" => "Mac and cheese",
        "option-2" => "Pizza",
        "option-3" => "Chicken soup",
        "option-4" => "Ice cream"
    ],
    [
        "question" => "How do you feel about reality TV shows?",
        "option-1" => "Love them!",
        "option-2" => "They're okay",
        "option-3" => "Not really a fan",
        "option-4" => "Absolutely hate them!"
    ],
    [
        "question" => "Which outdoor activity do you enjoy the most?",
        "option-1" => "Hiking",
        "option-2" => "Fishing",
        "option-3" => "Camping",
        "option-4" => "Picnicking"
    ],
    [
        "question" => "How do you feel about social media influencers?",
        "option-1" => "Love them!",
        "option-2" => "They're okay",
        "option-3" => "Not a fan",
        "option-4" => "Not sure"
    ],
    [
        "question" => "What's your favorite way to spend a rainy day?",
        "option-1" => "Reading a book",
        "option-2" => "Watching movies",
        "option-3" => "Baking",
        "option-4" => "Doing nothing"
    ],
    [
        "question" => "What's your preferred style of dress?",
        "option-1" => "Casual",
        "option-2" => "Formal",
        "option-3" => "Sporty",
        "option-4" => "Trendy"
    ],
    [
        "question" => "How do you feel about pets?",
        "option-1" => "Love them!",
        "option-2" => "They're okay",
        "option-3" => "Not a fan",
        "option-4" => "Prefer wild animals"
    ],
    [
        "question" => "What's your favorite kind of soup?",
        "option-1" => "Tomato",
        "option-2" => "Chicken Noodle",
        "option-3" => "Vegetable",
        "option-4" => "Minestrone"
    ],
    [
        "question" => "What's your preferred way to learn?",
        "option-1" => "Visually",
        "option-2" => "Audibly",
        "option-3" => "Kinesthetically",
        "option-4" => "Reading"
    ],
    [
        "question" => "How do you feel about Mondays?",
        "option-1" => "Love them!",
        "option-2" => "They're okay",
        "option-3" => "Not a fan",
        "option-4" => "I hate them!"
    ],
    [
        "question" => "Which type of footwear do you prefer?",
        "option-1" => "Sneakers",
        "option-2" => "Sandals",
        "option-3" => "Boots",
        "option-4" => "Loafers"
    ],
    [
        "question" => "Do you enjoy cooking?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer takeout"
    ],
    [
        "question" => "What's your favorite way to celebrate your birthday?",
        "option-1" => "Party with friends",
        "option-2" => "Quiet dinner",
        "option-3" => "Traveling",
        "option-4" => "Staying home"
    ],
    [
        "question" => "Do you prefer early mornings or late nights?",
        "option-1" => "Early mornings",
        "option-2" => "Late nights",
        "option-3" => "Both are good",
        "option-4" => "Neither"
    ],
    [
        "question" => "What's your go-to source of news?",
        "option-1" => "TV",
        "option-2" => "Online articles",
        "option-3" => "Social media",
        "option-4" => "Podcasts"
    ],
    [
        "question" => "How do you feel about road trips?",
        "option-1" => "Love them!",
        "option-2" => "They're okay",
        "option-3" => "Not a fan",
        "option-4" => "I prefer flying"
    ],
    [
        "question" => "How important is sleep to you?",
        "option-1" => "Very important",
        "option-2" => "Somewhat important",
        "option-3" => "Not really",
        "option-4" => "I can survive on little"
    ],
    [
        "question" => "What's your favorite kind of tea?",
        "option-1" => "Green tea",
        "option-2" => "Black tea",
        "option-3" => "Herbal tea",
        "option-4" => "I don't drink tea"
    ],
    [
        "question" => "Do you enjoy working from home?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "Prefer working in an office"
    ],
    [
        "question" => "How do you feel about summer?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer winter"
    ],
    [
        "question" => "What's your go-to breakfast food?",
        "option-1" => "Pancakes",
        "option-2" => "Cereal",
        "option-3" => "Omelette",
        "option-4" => "Smoothie"
    ],
    [
        "question" => "How do you feel about outdoor festivals?",
        "option-1" => "Love them!",
        "option-2" => "They're okay",
        "option-3" => "Not a fan",
        "option-4" => "Never been to one"
    ],
    [
        "question" => "What's your favorite kind of cake?",
        "option-1" => "Chocolate cake",
        "option-2" => "Vanilla cake",
        "option-3" => "Red velvet cake",
        "option-4" => "Cheesecake"
    ],
    [
        "question" => "How do you feel about New Year's resolutions?",
        "option-1" => "Love them!",
        "option-2" => "They're okay",
        "option-3" => "Not really",
        "option-4" => "I don't make them"
    ],
    [
        "question" => "What's your favorite way to relax?",
        "option-1" => "Reading a book",
        "option-2" => "Taking a bath",
        "option-3" => "Watching TV",
        "option-4" => "Listening to music"
    ],
    [
        "question" => "How do you feel about sports?",
        "option-1" => "Love them!",
        "option-2" => "They're okay",
        "option-3" => "Not a fan",
        "option-4" => "Prefer watching movies"
    ],
    [
        "question" => "Do you enjoy gardening?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer indoor plants"
    ],
    [
        "question" => "What's your favorite type of cookie?",
        "option-1" => "Chocolate chip",
        "option-2" => "Oatmeal raisin",
        "option-3" => "Peanut butter",
        "option-4" => "Sugar cookie"
    ],
    [
        "question" => "How do you feel about online dating?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not a fan",
        "option-4" => "Never tried"
    ],
    [
        "question" => "What's your favorite part of a vacation?",
        "option-1" => "Exploring new places",
        "option-2" => "Trying new foods",
        "option-3" => "Relaxing",
        "option-4" => "Spending time with friends"
    ],
    [
        "question" => "How do you feel about reality TV?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not a fan",
        "option-4" => "I prefer dramas"
    ],
    [
        "question" => "What's your preferred ice cream topping?",
        "option-1" => "Sprinkles",
        "option-2" => "Chocolate syrup",
        "option-3" => "Fruit",
        "option-4" => "Nuts"
    ],
    [
        "question" => "How do you feel about small talk?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer deep conversations"
    ],
    [
        "question" => "What's your favorite breakfast beverage?",
        "option-1" => "Coffee",
        "option-2" => "Tea",
        "option-3" => "Juice",
        "option-4" => "Smoothie"
    ],
    [
        "question" => "How do you feel about classical music?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer pop"
    ],
    [
        "question" => "How do you feel about socks?",
        "option-1" => "Love them!",
        "option-2" => "They're okay",
        "option-3" => "Not really",
        "option-4" => "I prefer going barefoot"
    ],
    [
        "question" => "Do you enjoy taking pictures?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer being in the moment"
    ],
    [
        "question" => "How do you feel about camping?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer hotels"
    ],
    [
        "question" => "What's your favorite kind of pie?",
        "option-1" => "Apple pie",
        "option-2" => "Pumpkin pie",
        "option-3" => "Cherry pie",
        "option-4" => "Pecan pie"
    ],
    [
        "question" => "How do you feel about wearing mismatched socks?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer matching pairs"
    ],
    [
        "question" => "Do you prefer cats or dogs?",
        "option-1" => "Cats",
        "option-2" => "Dogs",
        "option-3" => "Both are great",
        "option-4" => "Neither"
    ],
    [
        "question" => "How do you feel about video games?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer board games"
    ],
    [
        "question" => "What's your favorite flavor of chips?",
        "option-1" => "Barbecue",
        "option-2" => "Sour cream and onion",
        "option-3" => "Cheddar cheese",
        "option-4" => "Salt and vinegar"
    ],
    [
        "question" => "How do you feel about social media?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer face-to-face interactions"
    ],
    [
        "question" => "Do you enjoy going to the beach?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer the mountains"
    ],
    [
        "question" => "What's your favorite way to exercise?",
        "option-1" => "Running",
        "option-2" => "Yoga",
        "option-3" => "Weightlifting",
        "option-4" => "Dancing"
    ],
    [
        "question" => "How do you feel about spicy food?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I can't handle spice"
    ],
    [
        "question" => "What's your favorite kind of sandwich?",
        "option-1" => "BLT",
        "option-2" => "Club sandwich",
        "option-3" => "Grilled cheese",
        "option-4" => "Veggie sandwich"
    ],
    [
        "question" => "How do you feel about thrift shopping?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer retail shopping"
    ],
    [
        "question" => "What's your favorite holiday?",
        "option-1" => "Christmas",
        "option-2" => "Halloween",
        "option-3" => "Thanksgiving",
        "option-4" => "New Year's"
    ],
    [
        "question" => "Do you enjoy watching documentaries?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer fiction"
    ],
    [
        "question" => "How do you feel about roller coasters?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer gentle rides"
    ],
    [
        "question" => "What's your favorite type of fruit?",
        "option-1" => "Apples",
        "option-2" => "Bananas",
        "option-3" => "Grapes",
        "option-4" => "Oranges"
    ],
    [
        "question" => "Do you enjoy playing board games?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer video games"
    ],
    [
        "question" => "How do you feel about eating breakfast?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I skip it often"
    ],
    [
        "question" => "What's your favorite outdoor activity?",
        "option-1" => "Hiking",
        "option-2" => "Biking",
        "option-3" => "Picnicking",
        "option-4" => "Gardening"
    ],
    [
        "question" => "Do you prefer city life or country life?",
        "option-1" => "City life",
        "option-2" => "Country life",
        "option-3" => "Both have their perks",
        "option-4" => "Neither"
    ],
    [
        "question" => "How do you feel about tattoos?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I don't like them"
    ],
    [
        "question" => "What's your favorite time of day?",
        "option-1" => "Morning",
        "option-2" => "Afternoon",
        "option-3" => "Evening",
        "option-4" => "Night"
    ],
    [
        "question" => "Do you enjoy attending concerts?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer smaller performances"
    ],
    [
        "question" => "How do you feel about meditation?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I haven't tried"
    ],
    [
        "question" => "What's your favorite type of weather?",
        "option-1" => "Sunny",
        "option-2" => "Rainy",
        "option-3" => "Snowy",
        "option-4" => "Windy"
    ],
    [
        "question" => "Do you prefer dogs or cats?",
        "option-1" => "Dogs",
        "option-2" => "Cats",
        "option-3" => "Both are great",
        "option-4" => "Neither"
    ],
    [
        "question" => "How do you feel about the ocean?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer lakes"
    ],
    [
        "question" => "Do you enjoy hiking?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer indoor activities"
    ],
    [
        "question" => "What's your favorite type of chocolate?",
        "option-1" => "Dark chocolate",
        "option-2" => "Milk chocolate",
        "option-3" => "White chocolate",
        "option-4" => "I don't like chocolate"
    ],
    [
        "question" => "How do you feel about public speaking?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I dread it"
    ],
    [
        "question" => "What's your preferred form of exercise?",
        "option-1" => "Cardio",
        "option-2" => "Strength training",
        "option-3" => "Yoga",
        "option-4" => "Dance"
    ],
    [
        "question" => "How do you feel about the winter season?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer summer"
    ],
    [
        "question" => "Do you enjoy watching anime?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer live-action"
    ],
    [
        "question" => "What's your favorite type of flower?",
        "option-1" => "Roses",
        "option-2" => "Tulips",
        "option-3" => "Daisies",
        "option-4" => "Sunflowers"
    ],
    [
        "question" => "How do you feel about online shopping?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer shopping in stores"
    ],
    [
        "question" => "What's your favorite video game genre?",
        "option-1" => "Action",
        "option-2" => "Adventure",
        "option-3" => "Puzzle",
        "option-4" => "Strategy"
    ],
    [
        "question" => "Do you enjoy trying new foods?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I stick to what I know"
    ],
    [
        "question" => "How do you feel about camping?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer hotels"
    ],
    [
        "question" => "What's your favorite pizza topping?",
        "option-1" => "Pepperoni",
        "option-2" => "Mushrooms",
        "option-3" => "Olives",
        "option-4" => "Pineapple"
    ],
    [
        "question" => "Do you prefer coffee or tea?",
        "option-1" => "Coffee",
        "option-2" => "Tea",
        "option-3" => "Both are great",
        "option-4" => "Neither"
    ],
    [
        "question" => "How do you feel about art?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I don't like it"
    ],
    [
        "question" => "What's your favorite type of movie?",
        "option-1" => "Action",
        "option-2" => "Comedy",
        "option-3" => "Drama",
        "option-4" => "Horror"
    ],
    [
        "question" => "Do you enjoy playing sports?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer watching"
    ],
    [
        "question" => "How do you feel about live theater?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer movies"
    ],
    [
        "question" => "What's your favorite type of cake?",
        "option-1" => "Chocolate",
        "option-2" => "Vanilla",
        "option-3" => "Red velvet",
        "option-4" => "Carrot"
    ],
    [
        "question" => "Do you prefer hot or cold drinks?",
        "option-1" => "Hot",
        "option-2" => "Cold",
        "option-3" => "Both are great",
        "option-4" => "Neither"
    ],
    [
        "question" => "How do you feel about gardening?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I don't like it"
    ],
    [
        "question" => "What's your favorite color?",
        "option-1" => "Red",
        "option-2" => "Blue",
        "option-3" => "Green",
        "option-4" => "Yellow"
    ],
    [
        "question" => "Do you enjoy spending time with friends?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer alone time"
    ],
    [
        "question" => "How do you feel about cold weather?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer warm weather"
    ],
    [
        "question" => "What's your favorite genre of music?",
        "option-1" => "Pop",
        "option-2" => "Rock",
        "option-3" => "Classical",
        "option-4" => "Hip hop"
    ],
    [
        "question" => "Do you prefer books or movies?",
        "option-1" => "Books",
        "option-2" => "Movies",
        "option-3" => "Both are great",
        "option-4" => "Neither"
    ],
    [
        "question" => "How do you feel about science?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I don't like it"
    ],
    [
        "question" => "What's your favorite way to relax?",
        "option-1" => "Reading",
        "option-2" => "Watching TV",
        "option-3" => "Listening to music",
        "option-4" => "Taking a bath"
    ],
    [
        "question" => "Do you enjoy puzzles?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer action games"
    ],
    [
        "question" => "How do you feel about working out?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "What's your favorite way to celebrate?",
        "option-1" => "Partying",
        "option-2" => "Having a quiet dinner",
        "option-3" => "Going on a trip",
        "option-4" => "Spending time with family"
    ],
    [
        "question" => "Do you enjoy cooking?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer takeout"
    ],
    [
        "question" => "How do you feel about board games?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer video games"
    ],
    [
        "question" => "What's your favorite type of cuisine?",
        "option-1" => "Italian",
        "option-2" => "Mexican",
        "option-3" => "Chinese",
        "option-4" => "Indian"
    ],
    [
        "question" => "Do you enjoy visiting museums?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer outdoor activities"
    ],
    [
        "question" => "How do you feel about yoga?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I haven't tried"
    ],
    [
        "question" => "What's your favorite form of transportation?",
        "option-1" => "Car",
        "option-2" => "Bike",
        "option-3" => "Bus",
        "option-4" => "Walking"
    ],
    [
        "question" => "Do you prefer rainy or sunny days?",
        "option-1" => "Rainy",
        "option-2" => "Sunny",
        "option-3" => "Both are great",
        "option-4" => "Neither"
    ],
    [
        "question" => "How do you feel about online learning?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer in-person classes"
    ],
    [
        "question" => "What's your favorite type of seafood?",
        "option-1" => "Salmon",
        "option-2" => "Shrimp",
        "option-3" => "Tuna",
        "option-4" => "I don't like seafood"
    ],
    [
        "question" => "Do you enjoy dressing up?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer casual wear"
    ],
    [
        "question" => "How do you feel about virtual reality?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I haven't tried"
    ],
    [
        "question" => "What's your favorite type of soup?",
        "option-1" => "Tomato",
        "option-2" => "Chicken noodle",
        "option-3" => "Minestrone",
        "option-4" => "I don't like soup"
    ],
    [
        "question" => "Do you enjoy photography?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer painting"
    ],
    [
        "question" => "How do you feel about learning new languages?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I don't like it"
    ],
    [
        "question" => "What's your favorite way to stay active?",
        "option-1" => "Running",
        "option-2" => "Swimming",
        "option-3" => "Hiking",
        "option-4" => "I don't stay active"
    ],
    [
        "question" => "Do you enjoy road trips?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer flying"
    ],
    [
        "question" => "How do you feel about social media?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "What's your favorite type of flower?",
        "option-1" => "Rose",
        "option-2" => "Tulip",
        "option-3" => "Daisy",
        "option-4" => "Sunflower"
    ],
    [
        "question" => "Do you enjoy attending concerts?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer listening at home"
    ],
    [
        "question" => "How do you feel about nature walks?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer staying indoors"
    ],
    [
        "question" => "What's your favorite type of snack?",
        "option-1" => "Chips",
        "option-2" => "Chocolate",
        "option-3" => "Fruits",
        "option-4" => "Nuts"
    ],
    [
        "question" => "Do you enjoy playing video games?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer board games"
    ],
    [
        "question" => "How do you feel about themed parties?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "What's your favorite holiday?",
        "option-1" => "Christmas",
        "option-2" => "Halloween",
        "option-3" => "Thanksgiving",
        "option-4" => "New Year's"
    ],
    [
        "question" => "Do you enjoy shopping?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer online shopping"
    ],
    [
        "question" => "How do you feel about roller coasters?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "What's your favorite type of dance?",
        "option-1" => "Hip hop",
        "option-2" => "Ballet",
        "option-3" => "Salsa",
        "option-4" => "I don't dance"
    ],
    [
        "question" => "Do you enjoy writing?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer reading"
    ],
    [
        "question" => "How do you feel about self-care?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I don't prioritize it"
    ],
    [
        "question" => "What's your favorite type of dessert?",
        "option-1" => "Ice cream",
        "option-2" => "Cake",
        "option-3" => "Pie",
        "option-4" => "Cookies"
    ],
    [
        "question" => "Do you enjoy playing instruments?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I don't play instruments"
    ],
    [
        "question" => "How do you feel about fashion?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer comfort"
    ],
    [
        "question" => "What's your favorite time of day?",
        "option-1" => "Morning",
        "option-2" => "Afternoon",
        "option-3" => "Evening",
        "option-4" => "Night"
    ],
    [
        "question" => "Do you enjoy board games?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer video games"
    ],
    [
        "question" => "How do you feel about group projects?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "What's your favorite way to celebrate birthdays?",
        "option-1" => "Throwing a party",
        "option-2" => "Having a quiet dinner",
        "option-3" => "Going on a trip",
        "option-4" => "Spending time with family"
    ],
    [
        "question" => "Do you enjoy playing with pets?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I don't like pets"
    ],
    [
        "question" => "How do you feel about new technology?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer old tech"
    ],
    [
        "question" => "What's your favorite type of fruit?",
        "option-1" => "Apple",
        "option-2" => "Banana",
        "option-3" => "Grapes",
        "option-4" => "Orange"
    ],
    [
        "question" => "Do you enjoy taking long walks?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer short walks"
    ],
    [
        "question" => "How do you feel about meditation?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I haven't tried"
    ],
    [
        "question" => "What's your favorite type of cereal?",
        "option-1" => "Corn flakes",
        "option-2" => "Granola",
        "option-3" => "Frosted flakes",
        "option-4" => "I don't eat cereal"
    ],
    [
        "question" => "Do you enjoy hiking?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer flat terrain"
    ],
    [
        "question" => "How do you feel about DIY projects?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "What's your favorite board game?",
        "option-1" => "Monopoly",
        "option-2" => "Scrabble",
        "option-3" => "Chess",
        "option-4" => "I don't play board games"
    ],
    [
        "question" => "Do you enjoy playing sports?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer watching"
    ],
    [
        "question" => "How do you feel about puzzles?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "What's your favorite ice cream flavor?",
        "option-1" => "Chocolate",
        "option-2" => "Vanilla",
        "option-3" => "Strawberry",
        "option-4" => "Mint"
    ],
    [
        "question" => "Do you enjoy gardening?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "How do you feel about karaoke?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "What's your favorite type of music?",
        "option-1" => "Pop",
        "option-2" => "Rock",
        "option-3" => "Jazz",
        "option-4" => "Classical"
    ],
    [
        "question" => "Do you enjoy traveling?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer staying home"
    ],
    [
        "question" => "How do you feel about home-cooked meals?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer takeout"
    ],
    [
        "question" => "What's your favorite type of tea?",
        "option-1" => "Green tea",
        "option-2" => "Black tea",
        "option-3" => "Herbal tea",
        "option-4" => "I don't drink tea"
    ],
    [
        "question" => "Do you enjoy swimming?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "How do you feel about camping?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "What's your favorite kind of weather?",
        "option-1" => "Sunny",
        "option-2" => "Rainy",
        "option-3" => "Snowy",
        "option-4" => "Windy"
    ],
    [
        "question" => "Do you enjoy playing card games?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer video games"
    ],
    [
        "question" => "How do you feel about cooking?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "What's your favorite holiday tradition?",
        "option-1" => "Gift-giving",
        "option-2" => "Family dinners",
        "option-3" => "Decorating",
        "option-4" => "I don't have any"
    ],
    [
        "question" => "Do you enjoy theater performances?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer movies"
    ],
    [
        "question" => "How do you feel about exercise?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "What's your favorite breakfast food?",
        "option-1" => "Pancakes",
        "option-2" => "Omelet",
        "option-3" => "Cereal",
        "option-4" => "Toast"
    ],
    [
        "question" => "Do you enjoy doing puzzles?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "How do you feel about vintage items?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "What's your favorite vegetable?",
        "option-1" => "Carrot",
        "option-2" => "Broccoli",
        "option-3" => "Spinach",
        "option-4" => "I don't like vegetables"
    ],
    [
        "question" => "Do you enjoy listening to podcasts?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer music"
    ],
    [
        "question" => "How do you feel about history?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "What's your favorite mode of transportation?",
        "option-1" => "Car",
        "option-2" => "Bicycle",
        "option-3" => "Train",
        "option-4" => "Walking"
    ],
    [
        "question" => "Do you enjoy making crafts?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "How do you feel about art galleries?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "What's your favorite way to unwind?",
        "option-1" => "Reading",
        "option-2" => "Watching TV",
        "option-3" => "Listening to music",
        "option-4" => "Going out"
    ],
    [
        "question" => "Do you enjoy visiting museums?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "How do you feel about social events?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "What's your favorite type of salad?",
        "option-1" => "Caesar",
        "option-2" => "Greek",
        "option-3" => "Garden",
        "option-4" => "I don't eat salad"
    ],
    [
        "question" => "Do you enjoy thrillers?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I prefer comedies"
    ],
    [
        "question" => "How do you feel about the beach?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "What's your favorite kind of chocolate?",
        "option-1" => "Dark",
        "option-2" => "Milk",
        "option-3" => "White",
        "option-4" => "I don't like chocolate"
    ],
    [
        "question" => "Do you enjoy meditation?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "How do you feel about fashion?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "What's your favorite way to celebrate?",
        "option-1" => "Party",
        "option-2" => "Dinner",
        "option-3" => "Stay at home",
        "option-4" => "I don't celebrate"
    ],
    [
        "question" => "Do you enjoy learning new things?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "How do you feel about pets?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "What's your favorite fruit?",
        "option-1" => "Apple",
        "option-2" => "Banana",
        "option-3" => "Orange",
        "option-4" => "I don't like fruit"
    ],
    [
        "question" => "Do you enjoy attending workshops?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "How do you feel about online courses?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "What's your favorite snack?",
        "option-1" => "Chips",
        "option-2" => "Cookies",
        "option-3" => "Fruits",
        "option-4" => "I don't snack"
    ],
    [
        "question" => "Do you enjoy writing?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "How do you feel about roller coasters?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "What's your favorite type of cuisine?",
        "option-1" => "Italian",
        "option-2" => "Chinese",
        "option-3" => "Mexican",
        "option-4" => "I don't eat out"
    ],
    [
        "question" => "Do you enjoy outdoor activities?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "How do you feel about nightclubs?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "What's your favorite way to spend a weekend?",
        "option-1" => "Hanging out with friends",
        "option-2" => "Relaxing at home",
        "option-3" => "Doing something adventurous",
        "option-4" => "Catching up on sleep"
    ],
    [
        "question" => "Do you enjoy playing video games?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid them"
    ],
    [
        "question" => "How do you feel about science?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "What's your favorite way to keep fit?",
        "option-1" => "Running",
        "option-2" => "Yoga",
        "option-3" => "Weightlifting",
        "option-4" => "I don't exercise"
    ],
    [
        "question" => "Do you enjoy visiting new places?",
        "option-1" => "Love them!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "How do you feel about self-improvement?",
        "option-1" => "Love it!",
        "option-2" => "It's okay",
        "option-3" => "Not really",
        "option-4" => "I avoid it"
    ],
    [
        "question" => "What's your favorite type of coffee?",
        "option-1" => "Espresso",
        "option-2" => "Latte",
        "option-3" => "Cappuccino",
        "option-4" => "I don't drink coffee"
    ]
];

// Pick a random poll from the list
$randomPoll = $polls[array_rand($polls)];

// Return the selected poll in JSON format
echo json_encode($randomPoll, JSON_PRETTY_PRINT);