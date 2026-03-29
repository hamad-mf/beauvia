<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Shop;
use App\Models\FreelancerProfile;
use App\Models\Service;
use App\Models\StaffMember;
use App\Models\Review;
use App\Models\Booking;
use App\Models\TimeSlot;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- CATEGORIES ---
        $categories = [
            ['name' => 'Hair Salon', 'slug' => 'hair-salon', 'icon' => '💇', 'description' => 'Haircuts, styling, coloring & treatments', 'sort_order' => 1],
            ['name' => 'Nail Studio', 'slug' => 'nail-studio', 'icon' => '💅', 'description' => 'Manicure, pedicure & nail art', 'sort_order' => 2],
            ['name' => 'Spa & Wellness', 'slug' => 'spa-wellness', 'icon' => '🧖', 'description' => 'Massage, facials & body treatments', 'sort_order' => 3],
            ['name' => 'Barbershop', 'slug' => 'barbershop', 'icon' => '💈', 'description' => 'Men\'s cuts, shaves & grooming', 'sort_order' => 4],
            ['name' => 'Makeup Artist', 'slug' => 'makeup-artist', 'icon' => '💄', 'description' => 'Bridal, editorial & everyday makeup', 'sort_order' => 5],
            ['name' => 'Skincare', 'slug' => 'skincare', 'icon' => '✨', 'description' => 'Facials, peels & skin treatments', 'sort_order' => 6],
            ['name' => 'Massage', 'slug' => 'massage', 'icon' => '💆', 'description' => 'Deep tissue, Swedish & therapeutic', 'sort_order' => 7],
            ['name' => 'Fitness', 'slug' => 'fitness', 'icon' => '🏋️', 'description' => 'Personal training & yoga', 'sort_order' => 8],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // --- DEMO CUSTOMER ---
        $customer = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'customer@beauvia.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'phone' => '+1234567890',
            'city' => 'New York',
        ]);

        // --- SHOP OWNERS + SHOPS ---
        $shopsData = [
            [
                'owner' => ['name' => 'Emma Wilson', 'email' => 'emma@beauvia.com'],
                'shop' => [
                    'name' => 'Luxe Hair Studio', 'slug' => 'luxe-hair-studio', 'category_id' => 1,
                    'description' => 'Award-winning hair salon specializing in balayage, precision cuts, and luxury hair treatments. Our team of master stylists brings your dream hair to life.',
                    'address' => '123 Fifth Avenue, New York, NY 10010', 'city' => 'New York',
                    'phone' => '+1-212-555-0101', 'email' => 'hello@luxehairstudio.com',
                    'rating_avg' => 4.85, 'rating_count' => 127, 'is_featured' => true,
                ],
                'services' => [
                    ['name' => 'Women\'s Haircut & Style', 'price' => 85, 'duration_minutes' => 60, 'description' => 'Consultation, shampoo, precision cut & blow-dry styling'],
                    ['name' => 'Balayage Highlights', 'price' => 250, 'duration_minutes' => 180, 'description' => 'Hand-painted highlights for a natural sun-kissed look'],
                    ['name' => 'Keratin Treatment', 'price' => 300, 'duration_minutes' => 150, 'description' => 'Smoothing treatment for frizz-free, glossy hair lasting 3-5 months'],
                    ['name' => 'Men\'s Haircut', 'price' => 45, 'duration_minutes' => 30, 'description' => 'Classic or modern cut with styling'],
                    ['name' => 'Deep Conditioning', 'price' => 55, 'duration_minutes' => 45, 'description' => 'Intensive moisture treatment for damaged hair'],
                    ['name' => 'Full Color', 'price' => 150, 'duration_minutes' => 120, 'description' => 'All-over color with premium products'],
                ],
                'staff' => [
                    ['name' => 'Emma Wilson', 'title' => 'Master Stylist & Owner'],
                    ['name' => 'James Chen', 'title' => 'Senior Colorist'],
                    ['name' => 'Mia Rodriguez', 'title' => 'Stylist'],
                ],
            ],
            [
                'owner' => ['name' => 'Lisa Park', 'email' => 'lisa@beauvia.com'],
                'shop' => [
                    'name' => 'Serenity Spa & Wellness', 'slug' => 'serenity-spa', 'category_id' => 3,
                    'description' => 'Escape into tranquility at our luxurious spa. From rejuvenating massages to transformative facials, experience wellness at its finest.',
                    'address' => '456 Madison Avenue, New York, NY 10022', 'city' => 'New York',
                    'phone' => '+1-212-555-0202', 'email' => 'relax@serenityspa.com',
                    'rating_avg' => 4.92, 'rating_count' => 203, 'is_featured' => true,
                ],
                'services' => [
                    ['name' => 'Swedish Massage', 'price' => 120, 'duration_minutes' => 60, 'description' => 'Classic relaxation massage with long flowing strokes'],
                    ['name' => 'Deep Tissue Massage', 'price' => 150, 'duration_minutes' => 60, 'description' => 'Targeted pressure for chronic tension and knots'],
                    ['name' => 'Luxury Facial', 'price' => 175, 'duration_minutes' => 75, 'description' => 'Multi-step facial with premium skincare products'],
                    ['name' => 'Hot Stone Massage', 'price' => 180, 'duration_minutes' => 90, 'description' => 'Heated basalt stones combined with massage techniques'],
                    ['name' => 'Body Scrub & Wrap', 'price' => 200, 'duration_minutes' => 90, 'description' => 'Full body exfoliation followed by nourishing body wrap'],
                ],
                'staff' => [
                    ['name' => 'Lisa Park', 'title' => 'Lead Therapist & Owner'],
                    ['name' => 'David Kim', 'title' => 'Massage Therapist'],
                    ['name' => 'Ana Santos', 'title' => 'Esthetician'],
                ],
            ],
            [
                'owner' => ['name' => 'Marcus Blake', 'email' => 'marcus@beauvia.com'],
                'shop' => [
                    'name' => 'The Gentleman\'s Quarter', 'slug' => 'gentlemans-quarter', 'category_id' => 4,
                    'description' => 'Premium barbershop experience with classic and modern grooming. Complimentary whiskey with every visit.',
                    'address' => '789 Broadway, New York, NY 10003', 'city' => 'New York',
                    'phone' => '+1-212-555-0303', 'email' => 'book@gentlemansquarter.com',
                    'rating_avg' => 4.78, 'rating_count' => 89, 'is_featured' => true,
                ],
                'services' => [
                    ['name' => 'Classic Gentleman\'s Cut', 'price' => 55, 'duration_minutes' => 45, 'description' => 'Precision cut with hot towel and styling'],
                    ['name' => 'Hot Towel Shave', 'price' => 40, 'duration_minutes' => 30, 'description' => 'Traditional straight razor shave with hot towel'],
                    ['name' => 'Beard Trim & Shape', 'price' => 30, 'duration_minutes' => 20, 'description' => 'Expert beard grooming and sculpting'],
                    ['name' => 'The Full Experience', 'price' => 95, 'duration_minutes' => 75, 'description' => 'Haircut, shave, facial, and scalp massage'],
                ],
                'staff' => [
                    ['name' => 'Marcus Blake', 'title' => 'Master Barber & Owner'],
                    ['name' => 'Tony Russo', 'title' => 'Senior Barber'],
                ],
            ],
            [
                'owner' => ['name' => 'Sophie Laurent', 'email' => 'sophie@beauvia.com'],
                'shop' => [
                    'name' => 'Polished Nail Lounge', 'slug' => 'polished-nail-lounge', 'category_id' => 2,
                    'description' => 'Chic nail studio offering the latest trends in nail art, gel extensions, and luxury manicure experiences.',
                    'address' => '321 Park Avenue S, New York, NY 10010', 'city' => 'New York',
                    'phone' => '+1-212-555-0404',
                    'rating_avg' => 4.65, 'rating_count' => 156, 'is_featured' => false,
                ],
                'services' => [
                    ['name' => 'Classic Manicure', 'price' => 35, 'duration_minutes' => 30, 'description' => 'Shape, buff, cuticle care & polish'],
                    ['name' => 'Gel Manicure', 'price' => 55, 'duration_minutes' => 45, 'description' => 'Long-lasting gel polish with UV cure'],
                    ['name' => 'Luxury Pedicure', 'price' => 65, 'duration_minutes' => 60, 'description' => 'Soak, scrub, massage & polish'],
                    ['name' => 'Nail Art Design', 'price' => 80, 'duration_minutes' => 60, 'description' => 'Custom hand-painted nail art'],
                    ['name' => 'Acrylic Extensions', 'price' => 95, 'duration_minutes' => 90, 'description' => 'Full set of sculpted acrylic nails'],
                ],
                'staff' => [
                    ['name' => 'Sophie Laurent', 'title' => 'Nail Artist & Owner'],
                    ['name' => 'Yuki Tanaka', 'title' => 'Senior Nail Technician'],
                ],
            ],
            [
                'owner' => ['name' => 'Dr. Aisha Patel', 'email' => 'aisha@beauvia.com'],
                'shop' => [
                    'name' => 'Glow Skin Clinic', 'slug' => 'glow-skin-clinic', 'category_id' => 6,
                    'description' => 'Medical-grade skincare clinic offering advanced treatments. LED therapy, microneedling, and custom treatment plans.',
                    'address' => '555 Lexington Ave, New York, NY 10017', 'city' => 'New York',
                    'phone' => '+1-212-555-0505',
                    'rating_avg' => 4.90, 'rating_count' => 74, 'is_featured' => true,
                ],
                'services' => [
                    ['name' => 'HydraFacial', 'price' => 200, 'duration_minutes' => 60, 'description' => 'Deep cleanse, extract & hydrate with serums'],
                    ['name' => 'Microneedling', 'price' => 350, 'duration_minutes' => 75, 'description' => 'Collagen-inducing microneedling therapy'],
                    ['name' => 'Chemical Peel', 'price' => 150, 'duration_minutes' => 45, 'description' => 'Professional-grade peel for skin renewal'],
                    ['name' => 'LED Light Therapy', 'price' => 100, 'duration_minutes' => 30, 'description' => 'Anti-aging and acne reduction light therapy'],
                ],
                'staff' => [
                    ['name' => 'Dr. Aisha Patel', 'title' => 'Dermatologist & Owner'],
                    ['name' => 'Rachel Green', 'title' => 'Licensed Esthetician'],
                ],
            ],
            [
                'owner' => ['name' => 'Coach Mike Torres', 'email' => 'mike@beauvia.com'],
                'shop' => [
                    'name' => 'Peak Performance Studio', 'slug' => 'peak-performance', 'category_id' => 8,
                    'description' => 'Boutique fitness studio offering personalized training, yoga classes, and wellness coaching in a premium environment.',
                    'address' => '888 West End Ave, New York, NY 10025', 'city' => 'New York',
                    'phone' => '+1-212-555-0606',
                    'rating_avg' => 4.72, 'rating_count' => 61, 'is_featured' => false,
                ],
                'services' => [
                    ['name' => 'Personal Training Session', 'price' => 100, 'duration_minutes' => 60, 'description' => 'One-on-one tailored workout session'],
                    ['name' => 'Yoga Private Session', 'price' => 85, 'duration_minutes' => 60, 'description' => 'Private yoga session for all levels'],
                    ['name' => 'HIIT Group Class', 'price' => 30, 'duration_minutes' => 45, 'description' => 'High intensity interval training class'],
                    ['name' => 'Wellness Assessment', 'price' => 150, 'duration_minutes' => 90, 'description' => 'Full body composition and fitness assessment'],
                ],
                'staff' => [
                    ['name' => 'Mike Torres', 'title' => 'Head Trainer & Owner'],
                    ['name' => 'Zen Lee', 'title' => 'Yoga Instructor'],
                ],
            ],
        ];

        foreach ($shopsData as $data) {
            $owner = User::create(array_merge($data['owner'], [
                'password' => bcrypt('password'),
                'role' => 'shop_owner',
                'city' => 'New York',
            ]));

            $shop = Shop::create(array_merge($data['shop'], ['user_id' => $owner->id]));

            foreach ($data['services'] as $svc) {
                Service::create(array_merge($svc, [
                    'serviceable_type' => Shop::class,
                    'serviceable_id' => $shop->id,
                    'category_id' => $shop->category_id,
                ]));
            }

            foreach ($data['staff'] as $i => $staff) {
                StaffMember::create(array_merge($staff, ['shop_id' => $shop->id, 'sort_order' => $i]));
            }

            // Time slots (Mon-Sat 9am-7pm)
            for ($day = 1; $day <= 6; $day++) {
                TimeSlot::create([
                    'slotable_type' => Shop::class,
                    'slotable_id' => $shop->id,
                    'day_of_week' => $day,
                    'open_time' => '09:00',
                    'close_time' => '19:00',
                    'is_available' => true,
                ]);
            }
        }

        // --- FREELANCERS ---
        $freelancersData = [
            [
                'user' => ['name' => 'Olivia Martinez', 'email' => 'olivia@beauvia.com', 'city' => 'New York'],
                'profile' => [
                    'category_id' => 5, 'title' => 'Celebrity Makeup Artist',
                    'bio' => 'With 8 years of experience in editorial, bridal, and celebrity makeup, I bring luxury beauty to your doorstep. Featured in Vogue and Elle.',
                    'specialization' => 'Bridal & Editorial Makeup', 'experience_years' => 8,
                    'hourly_rate' => 150, 'is_mobile' => true, 'service_radius_km' => 25,
                    'rating_avg' => 4.95, 'rating_count' => 89, 'is_featured' => true, 'is_available' => true,
                ],
                'services' => [
                    ['name' => 'Bridal Makeup', 'price' => 350, 'duration_minutes' => 120, 'description' => 'Full bridal glam with trial consultation included'],
                    ['name' => 'Evening Glam', 'price' => 150, 'duration_minutes' => 60, 'description' => 'Red carpet-ready evening makeup'],
                    ['name' => 'Natural "No-Makeup" Look', 'price' => 100, 'duration_minutes' => 45, 'description' => 'Effortless, skin-forward makeup'],
                    ['name' => 'Makeup Lesson', 'price' => 200, 'duration_minutes' => 90, 'description' => 'Learn professional techniques personalized for you'],
                ],
            ],
            [
                'user' => ['name' => 'Jake Morrison', 'email' => 'jake@beauvia.com', 'city' => 'New York'],
                'profile' => [
                    'category_id' => 1, 'title' => 'Mobile Hair Stylist',
                    'bio' => 'Professional hair stylist specializing in editorial and event styling. I bring the salon experience to your home or office.',
                    'specialization' => 'Event & Editorial Hair', 'experience_years' => 6,
                    'hourly_rate' => 120, 'is_mobile' => true, 'service_radius_km' => 20,
                    'rating_avg' => 4.80, 'rating_count' => 67, 'is_featured' => true, 'is_available' => true,
                ],
                'services' => [
                    ['name' => 'Blowout & Style', 'price' => 80, 'duration_minutes' => 45, 'description' => 'Professional blowout with heat styling'],
                    ['name' => 'Updo & Event Hair', 'price' => 150, 'duration_minutes' => 75, 'description' => 'Elegant updos for weddings and events'],
                    ['name' => 'Haircut at Home', 'price' => 100, 'duration_minutes' => 60, 'description' => 'At-home precision haircut and styling'],
                    ['name' => 'Hair Treatment', 'price' => 90, 'duration_minutes' => 60, 'description' => 'Deep conditioning and scalp treatment'],
                ],
            ],
            [
                'user' => ['name' => 'Nina Petrov', 'email' => 'nina@beauvia.com', 'city' => 'New York'],
                'profile' => [
                    'category_id' => 7, 'title' => 'Licensed Massage Therapist',
                    'bio' => 'Certified massage therapist with expertise in sports recovery, prenatal massage, and deep tissue work. Bringing therapeutic healing to your space.',
                    'specialization' => 'Sports & Therapeutic Massage', 'experience_years' => 10,
                    'hourly_rate' => 130, 'is_mobile' => true, 'service_radius_km' => 15,
                    'rating_avg' => 4.88, 'rating_count' => 134, 'is_featured' => true, 'is_available' => true,
                ],
                'services' => [
                    ['name' => 'Deep Tissue Massage', 'price' => 140, 'duration_minutes' => 60, 'description' => 'Targeted deep tissue work for chronic tension'],
                    ['name' => 'Sports Recovery Massage', 'price' => 160, 'duration_minutes' => 75, 'description' => 'Post-workout recovery and injury prevention'],
                    ['name' => 'Prenatal Massage', 'price' => 130, 'duration_minutes' => 60, 'description' => 'Gentle, safe massage for expecting mothers'],
                    ['name' => 'Couples Massage', 'price' => 280, 'duration_minutes' => 90, 'description' => 'Side-by-side relaxation massage for two'],
                ],
            ],
            [
                'user' => ['name' => 'Priya Sharma', 'email' => 'priya@beauvia.com', 'city' => 'New York'],
                'profile' => [
                    'category_id' => 6, 'title' => 'Skincare Specialist',
                    'bio' => 'Holistic skincare expert combining ancient Ayurvedic practices with modern dermatology. Custom facials tailored to your skin.',
                    'specialization' => 'Ayurvedic Skincare', 'experience_years' => 7,
                    'hourly_rate' => 110, 'is_mobile' => true, 'service_radius_km' => 15,
                    'rating_avg' => 4.82, 'rating_count' => 56, 'is_featured' => false, 'is_available' => true,
                ],
                'services' => [
                    ['name' => 'Custom Facial Treatment', 'price' => 130, 'duration_minutes' => 75, 'description' => 'Personalized facial based on skin analysis'],
                    ['name' => 'Ayurvedic Face Massage', 'price' => 90, 'duration_minutes' => 45, 'description' => 'Traditional facial massage with herbal oils'],
                    ['name' => 'Acne Treatment', 'price' => 120, 'duration_minutes' => 60, 'description' => 'Targeted treatment for acne-prone skin'],
                ],
            ],
            [
                'user' => ['name' => 'Isabella Rossi', 'email' => 'isabella@beauvia.com', 'city' => 'New York'],
                'profile' => [
                    'category_id' => 2, 'title' => 'Mobile Nail Artist',
                    'bio' => 'Creative nail artist specializing in hand-painted designs, press-ons, and gel art. Instagram-worthy nails at your convenience.',
                    'specialization' => 'Nail Art & Gel Extensions', 'experience_years' => 5,
                    'hourly_rate' => 80, 'is_mobile' => true, 'service_radius_km' => 20,
                    'rating_avg' => 4.75, 'rating_count' => 98, 'is_featured' => false, 'is_available' => true,
                ],
                'services' => [
                    ['name' => 'Gel Manicure at Home', 'price' => 65, 'duration_minutes' => 50, 'description' => 'Professional gel manicure in your comfort'],
                    ['name' => 'Custom Nail Art Set', 'price' => 100, 'duration_minutes' => 90, 'description' => 'Hand-painted designs on all 10 nails'],
                    ['name' => 'Press-On Nail Fitting', 'price' => 50, 'duration_minutes' => 30, 'description' => 'Custom-fit luxury press-on nails'],
                ],
            ],
            [
                'user' => ['name' => 'Alex Chen', 'email' => 'alex@beauvia.com', 'city' => 'New York'],
                'profile' => [
                    'category_id' => 8, 'title' => 'Personal Trainer & Yoga Coach',
                    'bio' => 'ACE-certified personal trainer and RYT-500 yoga instructor. Specializing in strength training, flexibility, and mind-body fitness.',
                    'specialization' => 'Strength & Yoga', 'experience_years' => 9,
                    'hourly_rate' => 100, 'is_mobile' => true, 'service_radius_km' => 10,
                    'rating_avg' => 4.70, 'rating_count' => 43, 'is_featured' => false, 'is_available' => true,
                ],
                'services' => [
                    ['name' => 'In-Home Personal Training', 'price' => 110, 'duration_minutes' => 60, 'description' => 'Customized workout with all equipment provided'],
                    ['name' => 'Private Yoga Session', 'price' => 90, 'duration_minutes' => 60, 'description' => 'One-on-one yoga for flexibility and peace'],
                    ['name' => 'Outdoor Bootcamp', 'price' => 70, 'duration_minutes' => 45, 'description' => 'Park workout combining cardio and strength'],
                ],
            ],
        ];

        foreach ($freelancersData as $data) {
            $user = User::create(array_merge($data['user'], [
                'password' => bcrypt('password'),
                'role' => 'freelancer',
            ]));

            $profile = FreelancerProfile::create(array_merge($data['profile'], ['user_id' => $user->id]));

            foreach ($data['services'] as $svc) {
                Service::create(array_merge($svc, [
                    'serviceable_type' => FreelancerProfile::class,
                    'serviceable_id' => $profile->id,
                    'category_id' => $profile->category_id,
                ]));
            }

            // Time slots (Mon-Fri 8am-8pm, Sat 10am-6pm)
            for ($day = 1; $day <= 5; $day++) {
                TimeSlot::create([
                    'slotable_type' => FreelancerProfile::class,
                    'slotable_id' => $profile->id,
                    'day_of_week' => $day,
                    'open_time' => '08:00',
                    'close_time' => '20:00',
                    'is_available' => true,
                ]);
            }
            TimeSlot::create([
                'slotable_type' => FreelancerProfile::class,
                'slotable_id' => $profile->id,
                'day_of_week' => 6,
                'open_time' => '10:00',
                'close_time' => '18:00',
                'is_available' => true,
            ]);
        }

        // --- SAMPLE REVIEWS ---
        $reviewComments = [
            'Absolutely amazing experience! Will definitely be coming back.',
            'Professional, friendly, and incredibly talented. Highly recommend!',
            'The best service I\'ve ever had. Worth every penny.',
            'Wonderful atmosphere and exceptional results. 5 stars!',
            'So relaxing and the results exceeded my expectations.',
            'Incredible attention to detail. Left feeling completely refreshed.',
        ];

        $shops = Shop::all();
        foreach ($shops as $shop) {
            for ($i = 0; $i < 3; $i++) {
                Review::create([
                    'user_id' => $customer->id,
                    'reviewable_type' => Shop::class,
                    'reviewable_id' => $shop->id,
                    'rating' => rand(4, 5),
                    'comment' => $reviewComments[array_rand($reviewComments)],
                    'is_verified' => true,
                ]);
            }
        }

        $freelancerProfiles = FreelancerProfile::all();
        foreach ($freelancerProfiles as $profile) {
            for ($i = 0; $i < 2; $i++) {
                Review::create([
                    'user_id' => $customer->id,
                    'reviewable_type' => FreelancerProfile::class,
                    'reviewable_id' => $profile->id,
                    'rating' => rand(4, 5),
                    'comment' => $reviewComments[array_rand($reviewComments)],
                    'is_verified' => true,
                ]);
            }
        }

        // --- SAMPLE BOOKINGS ---
        $firstShop = Shop::first();
        $firstShopServices = $firstShop->services()->take(2)->get();
        $booking = Booking::create([
            'user_id' => $customer->id,
            'bookable_type' => Shop::class,
            'bookable_id' => $firstShop->id,
            'staff_member_id' => $firstShop->staffMembers()->first()?->id,
            'booking_date' => now()->addDays(3)->toDateString(),
            'start_time' => '10:00',
            'end_time' => '11:00',
            'total_price' => $firstShopServices->sum('price'),
            'status' => 'confirmed',
        ]);
        foreach ($firstShopServices as $svc) {
            $booking->services()->attach($svc->id, ['price' => $svc->price]);
        }

        $firstFreelancer = FreelancerProfile::first();
        $flServices = $firstFreelancer->services()->take(1)->get();
        $booking2 = Booking::create([
            'user_id' => $customer->id,
            'bookable_type' => FreelancerProfile::class,
            'bookable_id' => $firstFreelancer->id,
            'booking_date' => now()->addDays(5)->toDateString(),
            'start_time' => '14:00',
            'end_time' => '16:00',
            'total_price' => $flServices->sum('price'),
            'status' => 'pending',
            'customer_address' => '100 Central Park West, New York',
        ]);
        foreach ($flServices as $svc) {
            $booking2->services()->attach($svc->id, ['price' => $svc->price]);
        }
    }
}
