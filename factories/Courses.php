<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Courses implements FactoryContract
{
    /**
     * Construct the factory.
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }
    /**
     * {@inheritdoc}
     */
    public function create($limit = 1, $flatten = false, $options = [])
    {
        $accessid = $this->faker->randomLetter().$this->faker->randomLetter().$this->faker->randomNumber(4, true);
        $name = $this->faker->firstName() . ', ' . $this->faker->lastName();

        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'Winter Term 2099' => [[
                    'start_date' => '2099-01-09',
                    'end_date' => '2099-05-02',
                    'professor_accessid' => $accessid,
                    'professor_name' => $name,
                    'is_active' => '1',
                    'year' => '2099',
                    'month' => '1',
                    'semester_name' => 'Winter Term 2099',
                    'course_number' => '3620',
                    'course_name' => 'Introduction to Microcomputers',
                    'course_description' => 'Basics of digital systems, number systems, functional blocks of microcomputers, assembly language and machine code, applications of microcomputers and experimental demonstrations.  Introduction to digital logic.',
                    'pre_reqs' => 'null',
                    'short_code' => 'ECE',
                    'subject_name' => 'Electrical and Computer Eng',
                ]],
                'Current Term XXXX' => [[
                    'start_date' => date('Y-m-d', strtotime('-1 month')),
                    'end_date' => date('Y-m-d', strtotime('+1 month')),
                    'professor_accessid' => $accessid,
                    'professor_name' => $name,
                    'is_active' => '1',
                    'year' => 'XXXX',
                    'month' => '1',
                    'semester_name' => 'Current Term XXXX',
                    'course_number' => '3620',
                    'course_name' => 'Introduction to Microcomputers',
                    'course_description' => 'Basics of digital systems, number systems, functional blocks of microcomputers, assembly language and machine code, applications of microcomputers and experimental demonstrations.  Introduction to digital logic.',
                    'pre_reqs' => 'null',
                    'short_code' => 'ECE',
                    'subject_name' => 'Electrical and Computer Eng',
                ]],
                'Winter Term 2023' => [[
                    'start_date' => '2023-01-09',
                    'end_date' => '2023-05-02',
                    'professor_accessid' => $accessid,
                    'professor_name' => $name,
                    'is_active' => '1',
                    'year' => '2023',
                    'month' => '1',
                    'semester_name' => 'Winter Term 2023',
                    'course_number' => '3620',
                    'course_name' => 'Introduction to Microcomputers',
                    'course_description' => 'Basics of digital systems, number systems, functional blocks of microcomputers, assembly language and machine code, applications of microcomputers and experimental demonstrations.  Introduction to digital logic.',
                    'pre_reqs' => 'null',
                    'short_code' => 'ECE',
                    'subject_name' => 'Electrical and Computer Eng',
                ]],
                'Fall Term 2022' => [
                    [
                        'start_date' => '2022-08-30',
                        'end_date' => '2022-12-20',
                        'professor_accessid' => $accessid,
                        'professor_name' => $name,
                        'is_active' => '1',
                        'year' => '2022',
                        'month' => '9',
                        'semester_name' => 'Fall Term 2022',
                        'course_number' => '3620',
                        'course_name' => 'Introduction to Microcomputers',
                        'course_description' => 'Basics of digital systems, number systems, functional blocks of microcomputers, assembly language and machine code, applications of microcomputers and experimental demonstrations.  Introduction to digital logic.',
                        'pre_reqs' => 'null',
                        'short_code' => 'ECE',
                        'subject_name' => 'Electrical and Computer Eng',
                    ], [
                        'start_date' => '2022-08-30',
                        'end_date' => '2022-12-20',
                        'professor_accessid' => $accessid,
                        'professor_name' => $name,
                        'is_active' => '1',
                        'year' => '2022',
                        'month' => '9',
                        'semester_name' => 'Fall Term 2022',
                        'course_number' => '7995',
                        'course_name' => 'Special Topics in Electrical and Computer Engineering II',
                        'course_description' => 'A consideration of special subject matter in electrical and computer engineering.  Topics to be announced in  Schedule of Classes .',
                        'pre_reqs' => 'nul',
                        'short_code' => 'ECE',
                        'subject_name' => 'Electrical and Computer Eng',
                    ],
                ],
            ];
            $data[$i] = array_replace_recursive($data[$i], $options);
        }
        if ($limit === 1 && $flatten === true) {
            return current($data);
        }
        return $data;
    }
}
