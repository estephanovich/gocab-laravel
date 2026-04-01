<?php

namespace Database\Seeders;

use App\Models\LandingPage;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $content = [
            "en" => [
                "header" => [
                    "light_logo" => "/front/images/placeholder/142x36.png",
                    "dark_logo" => "/front/images/placeholder/142x36.png",
                    "menus" => [
                        'home',
                        'why_cab_booking',
                        'how_it_works',
                        'faqs',
                        'blogs',
                        'testimonials',
                        'raise_tickets'
                    ],
                    "status" => "1",
                    "btn_url" => "#app",
                    "btn_text" => 'Book Ride',
                ],
                "home" => [
                    'top_btn_text' => 'Book your Ride!!',
                    'top_btn_url' => '#',
                    "title" => "Ride with Comfort, Drive with Confidence",
                    "description" => "Experience smooth journeys with comfort and confidence, thanks to state-of-the-art features for convenience and safety.",
                    "button" => [
                        [
                            "text" => "User App",
                            "type" => "solid",
                            "url" => "https://play.google.com/store",
                        ],
                        [
                            "text" => "Driver App",
                            "type" => "outline",
                            "url" => "https://play.google.com/store"
                        ]
                    ],
                    "info_image" => "/front/images/placeholder/142x36.png",
                    "info_text" => "10k+ Downloads",
                    "info_ url" => "",
                    "info_description" => "Trusted by 10,000+ riders who choose ".env('APP_NAME')." for safe and seamless travel.",
                    "playstore_url" => "https://play.google.com/store",
                    "appstore_url" => "https://play.google.com/store",
                    "right_phone_image" => "/front/images/placeholder/428x685.png",
                    "status" => "1",
                ],
                "statistics" => [
                    "status" => "1",
                    "counters" => [
                        [
                            "description" => "Completed Rides with Happy Customers.",
                            "count" => "100000",
                        ],
                        [
                            "description" => "Active User Community Growing Daily.",
                            "count" => "50000",
                        ],
                        [
                            "description" => "Verified professional drivers.",
                            "count" => "30000",
                        ],
                        [
                            "description" => "Player Satisfaction Rate Guaranteed.",
                            "count" => "4.9",
                        ]
                    ]
                ],
                "feature" => [
                    "status" => "1",
                    "title" => "Why ".env('APP_NAME')." Stands Out as Your Go-To Ride Option",
                    "description" => "With ".env('APP_NAME').", enjoy affordable rates, safe journeys, and a user-friendly platform that makes travel easier and more enjoyable than ever before.",
                    "images" => [
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Real Time Driver Tracking",
                            "description" => "Track your driver's location in real time and stay updated throughout the ride."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Multiple Payments Gateways",
                            "description" => "Enjoy seamless payments with multiple secure gateways."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Accept & Reject Bidding",
                            "description" => "Take control of ride requests by accepting or rejecting driver bids."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Rental Vehicles",
                            "description" => "Choose from a variety of reliable rental vehicles to match your travel needs."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Hourly Package",
                            "description" => "Enjoy flexible hourly packages designed for short trips, quick errands, or city rides."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Multiple Language",
                            "description" => "Enjoy a user-friendly interface with support for multiple languages."
                        ],
                    ]
                ],
                "ride" => [
                    "status" => "1",
                    "title" => "Smooth Rides with ".env('APP_NAME')."",
                    "description" => "Enjoy smooth and stress-free travel with ".env('APP_NAME')." — designed to make every ride simple, convenient, and perfectly tailored to your needs.",
                    "step" => [
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Choose Your Ride",
                            "description" => "Pick the perfect ride for your journey with ease."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Pick Up Your Location",
                            "description" => "Easily choose your pickup spot with the interactive map."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Find your Vehicle",
                            "description" => "Quickly locate and choose the perfect vehicle for your ride."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Make a Payment",
                            "description" => "Pay securely with multiple payment options."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Rate your Experience",
                            "description" => "Share your feedback after your ride to help us improve service quality."
                        ]
                    ]
                ],
                "faq" => [
                    "title" => "Have Question in your Mind?",
                    "sub_title" => "Find quick answers to the most common questions about our services, features, and policies.",
                    "faqs" => [],
                    "status" => "1",
                ],
                "blog" => [
                    "title" => "Stay Updated with ".env('APP_NAME')."",
                    "sub_title" => "Be the first to know about exciting offers, latest updates, and helpful travel tips from ".env('APP_NAME').".",
                    "blogs" => [],
                    "status" => "1",
                ],
                "testimonial" => [
                    "title" => "What Our Users Say",
                    "sub_title" => "Real stories from our satisfied users. ".env('APP_NAME')." is transforming the way people commute.",
                    "testimonials" => [],
                    "status" => "1",
                ],
                "footer" => [
                    "footer_logo" => "front/images/placeholder/197x50.png",
                    "description" => "Get started in minutes—choose your ride, track your driver, and enjoy a hassle-free journey with ".env('APP_NAME')."!",
                    "newsletter" => [
                        "label" => "Subscribe our Newsletter",
                        "placeholder" => "Enter email address",
                        "button_text" => "Subscribe"
                    ],
                    'play_store_url' => "#!",
                    "app_store_url" => "#!",
                    "social_links" => [
                        "facebook"  => "https://www.facebook.com",
                        "google"    => "https://www.google.com",
                        "instagram" => "https://www.instagram.com",
                        "twitter-x" => "https://twitter.com",
                        "whatsapp"  => "https://wa.me/your-number",
                        "linkedin" => "https://linkedin.com",
                    ],
                    "pages" => [],
                    "right_image" => "front/images/placeholder/638x528.png",
                    "copyright" => "© ".env('APP_NAME')." All Rights & Reserves -",
                    "status" => "1",
                ],
                "seo" => [
                    "status" => "1",
                    "og_title" => "".env('APP_NAME')." - The Future of Convenient Transportation",
                    "meta_tags" => "".env('APP_NAME').", ride-hailing, taxi service, transportation, car service, book a ride, city transport, ride sharing, reliable taxi, on-demand rides.",
                    "meta_image" => "/front/images/logo.svg",
                    "meta_title" => "".env('APP_NAME')." - Your Reliable Ride-Hailing Partner",
                    "og_description" => "Discover ".env('APP_NAME').", your ultimate ride-hailing solution. Enjoy fast, safe, and reliable transportation at your fingertips.",
                    "meta_description" => "Experience seamless and convenient transportation with ".env('APP_NAME').". Book your ride easily and get to your destination safely."
                ],
                "analytics" => [
                    "status" => "1",
                    "pixel_id" => "XXXXXXXXXXXXX",
                    "pixel_status" => "1",
                    "measurement_id" => "UA-XXXXXX-XX",
                    "tag_id" => "XXXXXXXXXXXXX",
                    "chat_bot_id" => "XXXXXXXXXXX"
                ],
            ],
            "fr" => [
                "header" => [
                    "light_logo" => "/front/images/placeholder/142x36.png",
                    "dark_logo" => "/front/images/placeholder/142x36.png",
                    "menus" => [
                        'home',
                        'why_cab_booking',
                        'how_it_works',
                        'faqs',
                        'blogs',
                        'testimonials',
                        'raise_tickets'
                    ],
                    "status" => "1",
                    "btn_url" => "#app",
                    "btn_text" => 'Réserver une course',
                ],
                "home" => [
                    'top_btn_text' => 'Réservez votre Course!!',
                    'top_btn_url' => '#',
                    "title" => "Voyagez Confortablement, Conduisez en Toute Confiance",
                    "description" => "Vivez des trajets fluides avec confort et confiance, grâce à des fonctionnalités de pointe pour la commodité et la sécurité.",
                    "button" => [
                        [
                            "text" => "Application Utilisateur",
                            "type" => "solid",
                            "url" => "https://play.google.com/store",
                        ],
                        [
                            "text" => "Application Conducteur",
                            "type" => "outline",
                            "url" => "https://play.google.com/store"
                        ]
                    ],
                    "info_image" => "/front/images/placeholder/142x36.png",
                    "info_text" => "10k+ Téléchargements",
                    "info_description" => "Fiable pour 10 000+ conducteurs qui choisissent ".env('APP_NAME')." pour un voyage sûr et sans interruption.",
                    "bg_image" => '',
                    "playstore_url" => "https://play.google.com/store",
                    "appstore_url" => "https://play.google.com/store",
                    "right_phone_image" => "/front/images/placeholder/1.png",
                    "status" => "1",
                ],
                "statistics" => [
                    "status" => "1",
                    "counters" => [
                        [
                            "description" => "Offrant des courses de confiance à d'innombrables conducteurs heureux quotidiennement.",
                            "count" => "100000",
                        ],
                        [
                            "description" => "Connectant des milliers de personnes qui nous font confiance pour des courses fiables.",
                            "count" => "50000",
                        ],
                        [
                            "description" => "Conducteurs dévoués assurant des courses sûres, ponctuelles et confortables.",
                            "count" => "30000",
                        ],
                        [
                            "description" => "Évaluations positives qui reflètent la confiance et l'excellence du service.",
                            "count" => "4.9",
                        ]
                    ]
                ],
                "feature" => [
                    "status" => "1",
                    "title" => "Pourquoi ".env('APP_NAME')." se Distingue comme Votre Option de Course Préférée",
                    "description" => "Avec ".env('APP_NAME').", profitez de tarifs abordables, de voyages sûrs et d'une plateforme conviviale qui rend les déplacements plus faciles et plus agréables que jamais.",
                    "images" => [
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Suivi du Conducteur en Temps Réel",
                            "description" => "Suivez l'emplacement de votre conducteur en temps réel et restez informé tout au long du trajet."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Passerelles de Paiement Multiples",
                            "description" => "Profitez de paiements sans interruption avec plusieurs passerelles sécurisées."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Accepter et Rejeter les Offres",
                            "description" => "Prenez le contrôle des demandes de course en acceptant ou en refusant les offres des conducteurs."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Véhicules de Location",
                            "description" => "Choisissez parmi une variété de véhicules de location fiables adaptés à vos besoins de voyage."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Forfait Horaire",
                            "description" => "Profitez de forfaits horaires flexibles conçus pour les courts trajets, les courses rapides ou les trajets en ville."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Multilingue",
                            "description" => "Profitez d'une interface conviviale avec prise en charge de plusieurs langues."
                        ],
                    ]
                ],
                "ride" => [
                    "status" => "1",
                    "title" => "Trajets Fluides avec ".env('APP_NAME')."",
                    "description" => "Profitez de voyages fluides et sans stress avec ".env('APP_NAME')." — conçu pour rendre chaque course simple, pratique et parfaitement adaptée à vos besoins.",
                    "step" => [
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Choisissez Votre Course",
                            "description" => "Choisissez facilement la course parfaite pour votre voyage."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Choisissez Votre Lieu de Prise en Charge",
                            "description" => "Choisissez facilement votre lieu de prise en charge avec la carte interactive."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Trouvez Votre Véhicule",
                            "description" => "Localisez et choisissez rapidement le véhicule parfait pour votre course."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Effectuez un Paiement",
                            "description" => "Payez en toute sécurité avec plusieurs options de paiement."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Évaluez Votre Expérience",
                            "description" => "Partagez vos commentaires après votre course pour nous aider à améliorer la qualité du service."
                        ]
                    ]
                ],
                "faq" => [
                    "title" => "Des Questions en Tête ?",
                    "sub_title" => "Trouvez des réponses rapides aux questions les plus courantes sur nos services, fonctionnalités et politiques.",
                    "faqs" => [],
                    "status" => "1",
                ],
                "blog" => [
                    "title" => "Restez Informé avec ".env('APP_NAME')."",
                    "sub_title" => "Soyez le premier à connaître les offres passionnantes, les dernières mises à jour et les conseils de voyage utiles de ".env('APP_NAME').".",
                    "blogs" => [],
                    "status" => "1",
                ],
                "testimonial" => [
                    "title" => "Ce que Disent Nos Utilisateurs",
                    "sub_title" => "Histoires réelles de nos utilisateurs satisfaits. ".env('APP_NAME')." transforme la façon dont les gens se déplacent.",
                    "testimonials" => [],
                    "status" => "1",
                ],
                "footer" => [
                    "footer_logo" => "front/images/placeholder/197x50.png",
                    "description" => "Commencez en quelques minutes—choisissez votre course, suivez votre conducteur et profitez d'un voyage sans tracas avec ".env('APP_NAME')." !",
                    "newsletter" => [
                        "label" => "Abonnez-vous à notre Newsletter",
                        "placeholder" => "Entrez votre adresse e-mail",
                        "button_text" => "S'abonner"
                    ],
                    'play_store_url' => "#!",
                    "app_store_url" => "#!",
                    "social_links" => [
                        "facebook"  => "https://www.facebook.com",
                        "google"    => "https://www.google.com",
                        "instagram" => "https://www.instagram.com",
                        "twitter-x" => "https://twitter.com",
                        "whatsapp"  => "https://wa.me/your-number",
                        "linkedin" => "https://linkedin.com",
                    ],
                    "pages" => [],
                    "right_image" => "front/images/placeholder/638x528.png",
                    "copyright" => "© ".env('APP_NAME')." Tous Droits Réservés -",
                    "status" => "1",
                ],
                "seo" => [
                    "status" => "1",
                    "og_title" => "".env('APP_NAME')." - L'Avenir des Transports Pratiques",
                    "meta_tags" => "".env('APP_NAME').", ride-hailing, service de taxi, transport, service de voiture, réserver une course, transport urbain, covoiturage, taxi fiable, courses à la demande.",
                    "meta_image" => "/front/images/logo.svg",
                    "meta_title" => "".env('APP_NAME')." - Votre Partenaire Fiable de Ride-Hailing",
                    "og_description" => "Découvrez ".env('APP_NAME').", votre solution ultime de ride-hailing. Profitez de transports rapides, sûrs et fiables à portée de main.",
                    "meta_description" => "Vivez une expérience de transport fluide et pratique avec ".env('APP_NAME').". Réservez facilement votre course et arrivez à destination en toute sécurité."
                ],
                "analytics" => [
                    "status" => "1",
                    "pixel_id" => "XXXXXXXXXXXXX",
                    "pixel_status" => "1",
                    "measurement_id" => "UA-XXXXXX-XX",
                    "tag_id" => "XXXXXXXXXXXXX",
                    "chat_bot_id" => "XXXXXXXXXXX"
                ],
            ],
            "de" => [
                "header" => [
                    "light_logo" => "/front/images/placeholder/142x36.png",
                    "dark_logo" => "/front/images/placeholder/142x36.png",
                     "menus" => [
                        'home',
                        'why_cab_booking',
                        'how_it_works',
                        'faqs',
                        'blogs',
                        'testimonials',
                        'raise_tickets'
                    ],
                    "status" => "1",
                    "btn_url" => "#app",
                    "btn_text" => 'Fahrt Buchen',
                ],
                "home" => [
                    'top_btn_text' => 'Buchen Sie Ihre Fahrt!!',
                    'top_btn_url' => '#',
                    "title" => "Fahren Sie mit Komfort, Fahren Sie mit Vertrauen",
                    "description" => "Erleben Sie reibungslose Fahrten mit Komfort und Vertrauen, dank modernster Funktionen für Komfort und Sicherheit.",
                    "button" => [
                        [
                            "text" => "Benutzer-App",
                            "type" => "solid",
                            "url" => "https://play.google.com/store",
                        ],
                        [
                            "text" => "Fahrer-App",
                            "type" => "outline",
                            "url" => "https://play.google.com/store"
                        ]
                    ],
                    "info_image" => "/front/images/placeholder/142x36.png",
                    "info_text" => "10k+ Downloads",
                    "info_description" => "Vertrauen von 10.000+ Fahrern, die ".env('APP_NAME')." für sichere und nahtlose Reisen wählen.",
                    "bg_image" => '',
                    "playstore_url" => "https://play.google.com/store",
                    "appstore_url" => "https://play.google.com/store",
                    "right_phone_image" => "/front/images/placeholder/1.png",
                    "status" => "1",
                ],
                "statistics" => [
                    "status" => "1",
                    "counters" => [
                        [
                            "description" => "Täglich vertrauenswürdige Fahrten für unzählige glückliche Fahrer.",
                            "count" => "100000",
                        ],
                        [
                            "description" => "Verbinden Sie sich mit Tausenden, die uns für zuverlässige Fahrten vertrauen.",
                            "count" => "50000",
                        ],
                        [
                            "description" => "Engagierte Fahrer, die sichere, pünktliche und komfortable Fahrten gewährleisten.",
                            "count" => "30000",
                        ],
                        [
                            "description" => "Positive Bewertungen, die Vertrauen und Servicequalität widerspiegeln.",
                            "count" => "4.9",
                        ]
                    ]
                ],
                "feature" => [
                    "status" => "1",
                    "title" => "Warum ".env('APP_NAME')." als Ihre bevorzugte Fahrtoption Hervorsticht",
                    "description" => "Mit ".env('APP_NAME')." genießen Sie günstige Preise, sichere Fahrten und eine benutzerfreundliche Plattform, die das Reisen einfacher und angenehmer macht als je zuvor.",
                    "images" => [
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Echtzeit-Fahrerverfolgung",
                            "description" => "Verfolgen Sie den Standort Ihres Fahrers in Echtzeit und bleiben Sie während der Fahrt auf dem Laufenden."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Mehrere Zahlungsgateways",
                            "description" => "Genießen Sie nahtlose Zahlungen mit mehreren sicheren Gateways."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Angebote Annehmen & Ablehnen",
                            "description" => "Übernehmen Sie die Kontrolle über Fahrtanfragen, indem Sie Fahrerangebote annehmen oder ablehnen."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Mietfahrzeuge",
                            "description" => "Wählen Sie aus einer Vielzahl zuverlässiger Mietfahrzeuge, die Ihren Reisebedürfnissen entsprechen."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Stundenpaket",
                            "description" => "Genießen Sie flexible Stundenpakete für kurze Fahrten, schnelle Besorgungen oder Stadtfahrten."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "Mehrsprachig",
                            "description" => "Genießen Sie eine benutzerfreundliche Oberfläche mit Unterstützung für mehrere Sprachen."
                        ],
                    ]
                ],
                "ride" => [
                    "status" => "1",
                    "title" => "Reibungslose Fahrten mit ".env('APP_NAME')."",
                    "description" => "Genießen Sie reibungslose und stressfreie Fahrten mit ".env('APP_NAME')." — entwickelt, um jede Fahrt einfach, bequem und perfekt auf Ihre Bedürfnisse zugeschnitten zu machen.",
                    "step" => [
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Wählen Sie Ihre Fahrt",
                            "description" => "Wählen Sie problemlos die perfekte Fahrt für Ihre Reise."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Wählen Sie Ihren Abholort",
                            "description" => "Wählen Sie leicht Ihren Abholort mit der interaktiven Karte."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Finden Sie Ihr Fahrzeug",
                            "description" => "Finden und wählen Sie schnell das perfekte Fahrzeug für Ihre Fahrt."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Zahlen Sie",
                            "description" => "Zahlen Sie sicher mit mehreren Zahlungsoptionen."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "Bewerten Sie Ihre Erfahrung",
                            "description" => "Teilen Sie Ihr Feedback nach Ihrer Fahrt, um uns bei der Verbesserung der Servicequalität zu helfen."
                        ]
                    ]
                ],
                "faq" => [
                    "title" => "Haben Sie Fragen im Kopf?",
                    "sub_title" => "Finden Sie schnelle Antworten auf die häufigsten Fragen zu unseren Dienstleistungen, Funktionen und Richtlinien.",
                    "faqs" => [],
                    "status" => "1",
                ],
                "blog" => [
                    "title" => "Bleiben Sie mit ".env('APP_NAME')." auf dem Laufenden",
                    "sub_title" => "Seien Sie der Erste, der spannende Angebote, die neuesten Updates und hilfreiche Reisetipps von ".env('APP_NAME')." erfährt.",
                    "blogs" => [],
                    "status" => "1",
                ],
                "testimonial" => [
                    "title" => "Was Unsere Nutzer Sagen",
                    "sub_title" => "Echte Geschichten von unseren zufriedenen Nutzern. ".env('APP_NAME')." verändert die Art und Weise, wie Menschen pendeln.",
                    "testimonials" => [],
                    "status" => "1",
                ],
                "footer" => [
                    "footer_logo" => "front/images/placeholder/197x50.png",
                    "description" => "Starten Sie in wenigen Minuten—wählen Sie Ihre Fahrt, verfolgen Sie Ihren Fahrer und genießen Sie eine stressfreie Fahrt mit ".env('APP_NAME')."!",
                    "newsletter" => [
                        "label" => "Abonnieren Sie unseren Newsletter",
                        "placeholder" => "Geben Sie Ihre E-Mail-Adresse ein",
                        "button_text" => "Abonnieren"
                    ],
                    'play_store_url' => "#!",
                    "app_store_url" => "#!",
                    "social_links" => [
                        "facebook"  => "https://www.facebook.com",
                        "google"    => "https://www.google.com",
                        "instagram" => "https://www.instagram.com",
                        "twitter-x" => "https://twitter.com",
                        "whatsapp"  => "https://wa.me/your-number",
                        "linkedin" => "https://linkedin.com",
                    ],
                    "pages" => [],
                    "right_image" => "front/images/placeholder/638x528.png",
                    "copyright" => "© ".env('APP_NAME')." Alle Rechte Vorbehalten -",
                    "status" => "1",
                ],
                "seo" => [
                    "status" => "1",
                    "og_title" => "".env('APP_NAME')." - Die Zukunft des Bequemen Transports",
                    "meta_tags" => "".env('APP_NAME').", ride-hailing, Taxiservice, Transport, Autoservice, Fahrt buchen, Stadtverkehr, Mitfahrgelegenheit, zuverlässiges Taxi, On-Demand-Fahrten.",
                    "meta_image" => "/front/images/logo.svg",
                    "meta_title" => "".env('APP_NAME')." - Ihr Zuverlässiger Ride-Hailing-Partner",
                    "og_description" => "Entdecken Sie ".env('APP_NAME').", Ihre ultimative Ride-Hailing-Lösung. Genießen Sie schnellen, sicheren und zuverlässigen Transport.",
                    "meta_description" => "Erleben Sie nahtlosen und bequemen Transport mit ".env('APP_NAME').". Buchen Sie Ihre Fahrt einfach und kommen Sie sicher an Ihr Ziel."
                ],
                "analytics" => [
                    "status" => "1",
                    "pixel_id" => "XXXXXXXXXXXXX",
                    "pixel_status" => "1",
                    "measurement_id" => "UA-XXXXXX-XX",
                    "tag_id" => "XXXXXXXXXXXXX",
                    "chat_bot_id" => "XXXXXXXXXXX"
                ],
            ],
            "ar" => [
                "header" => [
                    "light_logo" => "/front/images/placeholder/142x36.png",
                    "dark_logo" => "/front/images/placeholder/142x36.png",
                     "menus" => [
                        'home',
                        'why_cab_booking',
                        'how_it_works',
                        'faqs',
                        'blogs',
                        'testimonials',
                        'raise_tickets'
                    ],
                    "status" => "1",
                    "btn_url" => "#app",
                    "btn_text" => 'احجز رحلة',
                ],
                "home" => [
                    'top_btn_text' => 'احجز رحلتك!!',
                    'top_btn_url' => '#',
                    "title" => "اركب براحة، سافر بثقة",
                    "description" => "اختبر رحلات سلسة مع الراحة والثقة، بفضل الميزات الحديثة للراحة والسلامة.",
                    "button" => [
                        [
                            "text" => "تطبيق المستخدم",
                            "type" => "solid",
                            "url" => "https://play.google.com/store",
                        ],
                        [
                            "text" => "تطبيق السائق",
                            "type" => "outline",
                            "url" => "https://play.google.com/store"
                        ]
                    ],
                    "info_image" => "/front/images/placeholder/142x36.png",
                    "info_text" => "10 ألف+ تحميل",
                    "info_description" => "موثوق به من قبل 10,000+ سائق يختارون ".env('APP_NAME')." للسفر الآمن والسلس.",
                    "bg_image" => '',
                    "playstore_url" => "https://play.google.com/store",
                    "appstore_url" => "https://play.google.com/store",
                    "right_phone_image" => "/front/images/placeholder/1.png",
                    "status" => "1",
                ],
                "statistics" => [
                    "status" => "1",
                    "counters" => [
                        [
                            "description" => "تقديم رحلات موثوقة لعدد لا يحصى من السائقين السعداء يوميًا.",
                            "count" => "100000",
                        ],
                        [
                            "description" => "التواصل مع الآلاف الذين يثقون بنا لرحلات موثوقة.",
                            "count" => "50000",
                        ],
                        [
                            "description" => "سائقون مخلصون يضمنون رحلات آمنة وفي الوقت المحدد ومريحة.",
                            "count" => "30000",
                        ],
                        [
                            "description" => "تقييمات إيجابية تعكس الثقة وتميز الخدمة.",
                            "count" => "4.9",
                        ]
                    ]
                ],
                "feature" => [
                    "status" => "1",
                    "title" => "لماذا ".env('APP_NAME')." تبرز كخيارك المفضل للرحلات",
                    "description" => "مع ".env('APP_NAME')."، استمتع بأسعار معقولة، رحلات آمنة، ومنصة سهلة الاستخدام تجعل السفر أسهل وأكثر متعة من أي وقت مضى.",
                    "images" => [
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "تتبع السائق في الوقت الحقيقي",
                            "description" => "تتبع موقع سائقك في الوقت الحقيقي وابق على اطلاع طوال الرحلة."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "بوابات دفع متعددة",
                            "description" => "استمتع بالمدفوعات السلسة مع بوابات دفع آمنة متعددة."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "قبول ورفض العروض",
                            "description" => "تحكم في طلبات الرحلات بقبول أو رفض عروض السائقين."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "مركبات الإيجار",
                            "description" => "اختر من مجموعة متنوعة من مركبات الإيجار الموثوقة التي تناسب احتياجات سفرك."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "باقة الساعة",
                            "description" => "استمتع بباقات ساعة مرنة مصممة للرحلات القصيرة والمهام السريعة أو رحلات المدينة."
                        ],
                        [
                            "image" => "front/images/placeholder/486x496.png",
                            "title" => "متعدد اللغات",
                            "description" => "استمتع بواجهة سهلة الاستخدام مع دعم لغات متعددة."
                        ],
                    ]
                ],
                "ride" => [
                    "status" => "1",
                    "title" => "رحلات سلسة مع ".env('APP_NAME')."",
                    "description" => "استمتع برحلات سلسة وخالية من الإجهاد مع ".env('APP_NAME')." — مصممة لجعل كل رحلة بسيطة ومريحة ومثالية لاحتياجاتك.",
                    "step" => [
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "اختر رحلتك",
                            "description" => "اختر الرحلة المثالية لرحلتك بسهولة."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "اختر موقع الالتقاط",
                            "description" => "اختر بسهولة موقع الالتقاط الخاص بك باستخدام الخريطة التفاعلية."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "ابحث عن مركبتك",
                            "description" => "حدد واختر المركبة المثالية لرحلتك بسرعة."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "قم بالدفع",
                            "description" => "ادفع بأمان مع خيارات دفع متعددة."
                        ],
                        [
                            "image" => "front/images/placeholder/348x701.png",
                            "title" => "قيم تجربتك",
                            "description" => "شارك ملاحظاتك بعد رحلتك لمساعدتنا في تحسين جودة الخدمة."
                        ]
                    ]
                ],
                "faq" => [
                    "title" => "هل لديك سؤال في ذهنك؟",
                    "sub_title" => "ابحث عن إجابات سريعة للأسئلة الأكثر شيوعًا حول خدماتنا وميزاتنا وسياساتنا.",
                    "faqs" => [],
                    "status" => "1",
                ],
                "blog" => [
                    "title" => "ابق على اطلاع مع ".env('APP_NAME')."",
                    "sub_title" => "كن أول من يعرف عن العروض المثيرة، آخر التحديثات، ونصائح السفر المفيدة من ".env('APP_NAME').".",
                    "blogs" => [],
                    "status" => "1",
                ],
                "testimonial" => [
                    "title" => "ما يقوله مستخدمونا",
                    "sub_title" => "قصص حقيقية من مستخدمينا الراضين. ".env('APP_NAME')." يغير طريقة تنقل الناس.",
                    "testimonials" => [],
                    "status" => "1",
                ],
                "footer" => [
                    "footer_logo" => "front/images/placeholder/197x50.png",
                    "description" => "ابدأ في دقائق—اختر رحلتك، تابع سائقك، واستمتع برحلة خالية من المتاعب مع ".env('APP_NAME')."!",
                    "newsletter" => [
                        "label" => "اشترك في نشرتنا الإخبارية",
                        "placeholder" => "أدخل عنوان البريد الإلكتروني",
                        "button_text" => "اشتراك"
                    ],
                    'play_store_url' => "#!",
                    "app_store_url" => "#!",
                    "social_links" => [
                        "facebook"  => "https://www.facebook.com",
                        "google"    => "https://www.google.com",
                        "instagram" => "https://www.instagram.com",
                        "twitter-x" => "https://twitter.com",
                        "whatsapp"  => "https://wa.me/your-number",
                        "linkedin" => "https://linkedin.com",
                    ],
                    "pages" => [],
                    "right_image" => "front/images/placeholder/638x528.png",
                    "copyright" => "© ".env('APP_NAME')." جميع الحقوق محفوظة -",
                    "status" => "1",
                ],
                "seo" => [
                    "status" => "1",
                    "og_title" => "".env('APP_NAME')." - مستقبل النقل المريح",
                    "meta_tags" => "".env('APP_NAME').", رايد هيلينغ, خدمة سيارات الأجرة, نقل, خدمة سيارات, احجز رحلة, نقل حضري, مشاركة الركوب, سيارة أجرة موثوقة, رحلات عند الطلب.",
                    "meta_image" => "/front/images/logo.svg",
                    "meta_title" => "".env('APP_NAME')." - شريكك الموثوق في رايد هيلينغ",
                    "og_description" => "اكتشف ".env('APP_NAME')."، حلك النهائي للرايد هيلينغ. استمتع بنقل سريع وآمن وموثوق.",
                    "meta_description" => "جرب النقل السلس والمريح مع ".env('APP_NAME').". احجز رحلتك بسهولة ووصل إلى وجهتك بأمان."
                ],
                "analytics" => [
                    "status" => "1",
                    "pixel_id" => "XXXXXXXXXXXXX",
                    "pixel_status" => "1",
                    "measurement_id" => "UA-XXXXXX-XX",
                    "tag_id" => "XXXXXXXXXXXXX",
                    "chat_bot_id" => "XXXXXXXXXXX"
                ],
            ],
        ];

        LandingPage::updateOrCreate(['content' => $content]);
    }
}
