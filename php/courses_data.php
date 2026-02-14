<?php
/**
 * Predefined Course Content Data
 * 
 * This file contains static content for each course including:
 * - Overview/Description
 * - Eligibility criteria
 * - Career options
 * - Duration and other details
 */

$COURSES_DATA = [
    'btech' => [
        'name' => 'B.Tech',
        'full_name' => 'Bachelor of Technology',
        'icon' => 'fas fa-microchip',
        'duration' => '4 Years',
        'avg_fees' => '₹1,00,000 - ₹4,00,000 per year',
        'short_description' => 'B.Tech is an undergraduate engineering degree that prepares students for technical careers in various engineering disciplines.',
        'description' => '
            <p>Bachelor of Technology (B.Tech) is one of the most sought-after undergraduate engineering programs in India. This 4-year professional degree program offers comprehensive education in various engineering disciplines including Computer Science, Electronics, Mechanical, Civil, and many more.</p>
            
            <h4>Why Choose B.Tech?</h4>
            <ul>
                <li><strong>High Demand:</strong> Engineers are always in demand across industries</li>
                <li><strong>Lucrative Salaries:</strong> Fresh graduates can expect packages ranging from ₹4-15 LPA</li>
                <li><strong>Diverse Specializations:</strong> Choose from 20+ specializations based on your interest</li>
                <li><strong>Innovation & Technology:</strong> Work on cutting-edge technologies</li>
                <li><strong>Global Opportunities:</strong> Engineering degrees are recognized worldwide</li>
            </ul>
            
            <h4>Popular Specializations</h4>
            <div class="specializations-grid">
                <span class="spec-tag">Computer Science & Engineering</span>
                <span class="spec-tag">Electronics & Communication</span>
                <span class="spec-tag">Mechanical Engineering</span>
                <span class="spec-tag">Civil Engineering</span>
                <span class="spec-tag">Electrical Engineering</span>
                <span class="spec-tag">Information Technology</span>
                <span class="spec-tag">Artificial Intelligence & ML</span>
                <span class="spec-tag">Data Science</span>
            </div>
        ',
        'eligibility' => '
            <h4>Academic Requirements</h4>
            <ul>
                <li>10+2 with Physics, Chemistry, and Mathematics (PCM)</li>
                <li>Minimum 60% aggregate marks (55% for reserved categories)</li>
                <li>Some institutions accept Biology instead of Mathematics for Biotech</li>
            </ul>
            
            <h4>Entrance Exams</h4>
            <ul>
                <li><strong>JEE Main:</strong> For NITs, IIITs, and other centrally funded institutions</li>
                <li><strong>JEE Advanced:</strong> For IITs (requires JEE Main qualification)</li>
                <li><strong>State CETs:</strong> MHT-CET, KCET, WBJEE, etc.</li>
                <li><strong>University Exams:</strong> IPU CET, VITEEE, SRMJEE, etc.</li>
            </ul>
            
            <h4>Age Limit</h4>
            <p>There is no upper age limit for most B.Tech admissions. Candidates must have completed 17 years by December 31st of the admission year.</p>
        ',
        'career_options' => '
            <h4>Top Career Paths</h4>
            <div class="career-grid">
                <div class="career-card">
                    <i class="fas fa-code"></i>
                    <h5>Software Developer</h5>
                    <p>₹6-20 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-database"></i>
                    <h5>Data Scientist</h5>
                    <p>₹8-25 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-cloud"></i>
                    <h5>Cloud Engineer</h5>
                    <p>₹8-22 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-robot"></i>
                    <h5>AI/ML Engineer</h5>
                    <p>₹10-30 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-shield-alt"></i>
                    <h5>Cybersecurity Analyst</h5>
                    <p>₹6-18 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-cogs"></i>
                    <h5>System Engineer</h5>
                    <p>₹5-15 LPA</p>
                </div>
            </div>
            
            <h4>Top Recruiters</h4>
            <p>Google, Microsoft, Amazon, TCS, Infosys, Wipro, HCL, Accenture, IBM, Cognizant, Adobe, Oracle, and many more Fortune 500 companies.</p>
            
            <h4>Higher Studies</h4>
            <ul>
                <li>M.Tech / MS in specialized fields</li>
                <li>MBA for management roles</li>
                <li>PhD for research careers</li>
                <li>Study abroad options (MS in USA, Germany, Canada)</li>
            </ul>
        ',
        'syllabus' => '
            <h4>B.Tech Syllabus Overview</h4>
            <p>The B.Tech curriculum is divided into 8 semesters over 4 years, covering fundamental engineering principles, specialized subjects, and practical training.</p>
            
            <h4>First Year (Common for All Branches)</h4>
            <ul>
                <li><strong>Mathematics:</strong> Calculus, Linear Algebra, Differential Equations</li>
                <li><strong>Physics:</strong> Mechanics, Thermodynamics, Waves & Optics, Modern Physics</li>
                <li><strong>Chemistry:</strong> Organic, Inorganic, Physical Chemistry</li>
                <li><strong>Programming:</strong> C/C++, Data Structures</li>
                <li><strong>Engineering Drawing & Graphics</strong></li>
                <li><strong>Workshop Practice</strong></li>
            </ul>
            
            <h4>Core Subjects (Branch-Specific)</h4>
            <p>From second year onwards, students study specialized subjects based on their chosen branch:</p>
            <ul>
                <li><strong>Computer Science:</strong> Algorithms, Operating Systems, Database Management, Computer Networks, Software Engineering</li>
                <li><strong>Mechanical:</strong> Thermodynamics, Fluid Mechanics, Machine Design, Manufacturing Processes</li>
                <li><strong>Electronics:</strong> Digital Electronics, Microprocessors, Communication Systems, Signal Processing</li>
                <li><strong>Civil:</strong> Structural Analysis, Building Materials, Surveying, Environmental Engineering</li>
                <li><strong>Electrical:</strong> Power Systems, Control Systems, Electrical Machines, Power Electronics</li>
            </ul>
            
            <h4>Practical Components</h4>
            <ul>
                <li>Laboratory sessions for each subject</li>
                <li>Industrial training/internship (6-8 weeks)</li>
                <li>Final year project/dissertation</li>
                <li>Workshop and field visits</li>
            </ul>
        ',
        'preparation_tips' => '
            <h4>How to Prepare for B.Tech Entrance Exams</h4>
            
            <h4>1. Understand the Exam Pattern</h4>
            <ul>
                <li>Familiarize yourself with the exam format (JEE Main, JEE Advanced, State CETs)</li>
                <li>Know the marking scheme and negative marking</li>
                <li>Practice with previous year papers</li>
            </ul>
            
            <h4>2. Build Strong Fundamentals</h4>
            <ul>
                <li><strong>Mathematics:</strong> Focus on Algebra, Calculus, Coordinate Geometry, Trigonometry</li>
                <li><strong>Physics:</strong> Master Mechanics, Thermodynamics, Optics, Modern Physics</li>
                <li><strong>Chemistry:</strong> Balance between Physical, Organic, and Inorganic Chemistry</li>
            </ul>
            
            <h4>3. Create a Study Schedule</h4>
            <ul>
                <li>Allocate time for each subject daily</li>
                <li>Dedicate 2-3 hours for problem-solving</li>
                <li>Take regular breaks to avoid burnout</li>
                <li>Revise weekly to retain concepts</li>
            </ul>
            
            <h4>4. Practice Regularly</h4>
            <ul>
                <li>Solve at least 50-100 problems daily</li>
                <li>Take mock tests every weekend</li>
                <li>Analyze mistakes and weak areas</li>
                <li>Time yourself to improve speed</li>
            </ul>
            
            <h4>5. Recommended Books</h4>
            <ul>
                <li><strong>Mathematics:</strong> RD Sharma, Cengage, Arihant</li>
                <li><strong>Physics:</strong> HC Verma, Resnick Halliday, DC Pandey</li>
                <li><strong>Chemistry:</strong> OP Tandon, MS Chouhan, NCERT</li>
            </ul>
            
            <h4>6. Time Management Tips</h4>
            <ul>
                <li>Start with easier questions to build confidence</li>
                <li>Don\'t spend too much time on a single problem</li>
                <li>Mark questions you\'re unsure about and revisit later</li>
                <li>Keep last 15 minutes for review</li>
            </ul>
        ',
        'mock_tests' => '
            <h4>Mock Test Series for B.Tech Entrance Exams</h4>
            <p>Regular practice with mock tests is essential for success in engineering entrance exams. Here\'s how to make the most of them:</p>
            
            <h4>Benefits of Mock Tests</h4>
            <ul>
                <li>Familiarize yourself with exam pattern and timing</li>
                <li>Identify strengths and weaknesses</li>
                <li>Improve time management skills</li>
                <li>Build exam-day confidence</li>
                <li>Track your progress over time</li>
            </ul>
            
            <h4>Recommended Mock Test Platforms</h4>
            <ul>
                <li><strong>NTA Official Mock Tests:</strong> Available on jeemain.nta.nic.in</li>
                <li><strong>Coaching Institute Tests:</strong> FIITJEE, Allen, Resonance, Aakash</li>
                <li><strong>Online Platforms:</strong> Embibe, Unacademy, Vedantu, BYJU\'S</li>
                <li><strong>Previous Year Papers:</strong> Solve last 10 years papers</li>
            </ul>
            
            <h4>How to Take Mock Tests Effectively</h4>
            <ul>
                <li>Take tests in exam-like conditions (quiet environment, no distractions)</li>
                <li>Stick to the actual exam duration</li>
                <li>Don\'t check answers immediately after the test</li>
                <li>Analyze performance: identify topics needing more practice</li>
                <li>Review solutions for all questions, even correct ones</li>
            </ul>
            
            <h4>Frequency</h4>
            <p>Take at least 2-3 mock tests per week in the final 3 months before the exam. Increase frequency to daily tests in the last month.</p>
        ',
        'question_papers' => '
            <h4>Previous Year Question Papers</h4>
            <p>Solving previous year question papers is one of the most effective preparation strategies. It helps you understand:</p>
            <ul>
                <li>Exam pattern and difficulty level</li>
                <li>Important topics and frequently asked questions</li>
                <li>Time management requirements</li>
                <li>Your current preparation level</li>
            </ul>
            
            <h4>Where to Find Question Papers</h4>
            <ul>
                <li><strong>Official Websites:</strong> NTA website for JEE Main papers</li>
                <li><strong>Coaching Institutes:</strong> Most institutes provide previous year papers</li>
                <li><strong>Books:</strong> Arihant, Disha, MTG publish compilation books</li>
                <li><strong>Online Platforms:</strong> Embibe, Unacademy, Vedantu offer free access</li>
            </ul>
            
            <h4>How to Use Question Papers</h4>
            <ul>
                <li>Start solving papers after completing syllabus</li>
                <li>Solve papers topic-wise first, then full-length papers</li>
                <li>Time yourself while solving</li>
                <li>Analyze mistakes and revise weak topics</li>
                <li>Solve papers from last 5-10 years</li>
            </ul>
            
            <h4>Important Topics (Based on Previous Papers)</h4>
            <ul>
                <li><strong>Mathematics:</strong> Calculus, Algebra, Coordinate Geometry</li>
                <li><strong>Physics:</strong> Mechanics, Thermodynamics, Modern Physics</li>
                <li><strong>Chemistry:</strong> Organic Chemistry reactions, Physical Chemistry calculations</li>
            </ul>
        ',
        'study_material' => '
            <h4>Study Material for B.Tech Entrance Exams</h4>
            
            <h4>NCERT Books (Foundation)</h4>
            <ul>
                <li>NCERT Class 11 & 12 Physics, Chemistry, Mathematics</li>
                <li>Essential for building strong fundamentals</li>
                <li>Many questions are directly from NCERT</li>
            </ul>
            
            <h4>Recommended Reference Books</h4>
            <ul>
                <li><strong>Mathematics:</strong> RD Sharma, Cengage Series, Arihant, ML Khanna</li>
                <li><strong>Physics:</strong> HC Verma (Concepts of Physics), Resnick Halliday, DC Pandey</li>
                <li><strong>Chemistry:</strong> OP Tandon, MS Chouhan, Morrison & Boyd (Organic)</li>
            </ul>
            
            <h4>Online Resources</h4>
            <ul>
                <li><strong>Video Lectures:</strong> Khan Academy, Unacademy, Vedantu, BYJU\'S</li>
                <li><strong>Practice Platforms:</strong> Embibe, Toppr, Meritnation</li>
                <li><strong>Doubt Solving:</strong> Online forums, Telegram groups, Discord communities</li>
            </ul>
            
            <h4>Formula Sheets & Quick Revision</h4>
            <ul>
                <li>Create your own formula notebook</li>
                <li>Use flashcards for quick revision</li>
                <li>Download formula sheets from coaching institutes</li>
            </ul>
            
            <h4>Important Notes</h4>
            <ul>
                <li>Make chapter-wise notes while studying</li>
                <li>Highlight important formulas and concepts</li>
                <li>Create mind maps for complex topics</li>
                <li>Revise notes regularly</li>
            </ul>
        ',
        'faqs' => '
            <h4>Frequently Asked Questions (FAQs)</h4>
            
            <div class="faq-item">
                <h4>Q1. What is the difference between B.Tech and BE?</h4>
                <p><strong>A:</strong> B.Tech (Bachelor of Technology) focuses more on practical and application-based learning, while BE (Bachelor of Engineering) is more theory-oriented. However, both degrees are equivalent and recognized equally by employers and for higher studies.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q2. Which entrance exam should I take for B.Tech?</h4>
                <p><strong>A:</strong> JEE Main is the most common exam for admission to NITs, IIITs, and GFTIs. For IITs, you need to qualify JEE Main and then appear for JEE Advanced. State-level exams like MHT-CET, KCET are for state colleges. University-specific exams like VITEEE, SRMJEE are for private universities.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q3. What is a good JEE Main rank for B.Tech?</h4>
                <p><strong>A:</strong> Rank below 10,000: Top NITs and IIITs. Rank 10,000-50,000: Good NITs and reputed private colleges. Rank 50,000-1,00,000: Decent engineering colleges. Rank above 1,00,000: Many options available in private colleges.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q4. Can I do B.Tech without JEE?</h4>
                <p><strong>A:</strong> Yes, many private universities and state colleges accept students based on 12th board marks or their own entrance exams. However, for top colleges (IITs, NITs, IIITs), JEE is mandatory.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q5. What is the average salary after B.Tech?</h4>
                <p><strong>A:</strong> Average starting salary ranges from ₹4-8 LPA for most graduates. Top colleges (IITs, NITs) see packages of ₹10-20 LPA. With experience and skills, salaries can reach ₹20-50 LPA or higher in tech companies.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q6. Which B.Tech branch has the best scope?</h4>
                <p><strong>A:</strong> Computer Science Engineering (CSE) currently has the highest demand and best placement opportunities. Other promising branches include Electronics & Communication, Mechanical, Electrical, and emerging fields like AI/ML, Data Science.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q7. Is B.Tech necessary for software jobs?</h4>
                <p><strong>A:</strong> While B.Tech is preferred, many companies hire BCA, MCA, or even self-taught programmers. However, B.Tech from a good college provides better opportunities, higher packages, and faster career growth.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q8. Can I change my branch after first year?</h4>
                <p><strong>A:</strong> Some colleges allow branch change based on first-year CGPA and availability of seats. The process varies by college. Check with your specific college\'s policy.</p>
            </div>
        ',
        'key_info' => [
            'Duration' => '4 Years',
            'Total Marks' => 'Varies by University',
            'Exam Pattern' => 'Entrance Exam Based',
            'Languages' => 'English, Hindi (varies by exam)',
            'No. of Attempts' => 'Unlimited (varies by exam)',
            'Application Fee' => '₹500 - ₹2,000',
            'Official Website' => 'Varies by exam (JEE Main: jeemain.nta.nic.in)',
            'Colleges Available' => '1000+',
            'Average Fees' => '₹1,00,000 - ₹4,00,000 per year',
            'Top Colleges' => 'IITs, NITs, IIITs, BITS, VIT, SRM'
        ],
        'specializations' => [
            'Computer Science Engineering' => 'CSE',
            'Mechanical Engineering' => 'ME',
            'Civil Engineering' => 'CE',
            'Electronics and Communication Engineering' => 'ECE',
            'Electrical Engineering' => 'EE',
            'Information Technology' => 'IT',
            'Chemical Engineering' => 'CHE',
            'Aerospace Engineering' => 'AE',
            'Biotechnology' => 'BT',
            'Artificial Intelligence & Machine Learning' => 'AI/ML'
        ],
        'updates' => [
            [
                'title' => 'JEE Main 2026 Registration Open',
                'date' => '2026-01-10',
                'author' => 'Eduspray Team',
                'content' => 'Registration for JEE Main 2026 Session 1 is now open. Candidates can apply through the official NTA website.'
            ],
            [
                'title' => 'New Engineering Colleges Added',
                'date' => '2026-01-08',
                'author' => 'Eduspray Team',
                'content' => 'We have added 50+ new engineering colleges to our database. Check out the latest options for B.Tech admissions.'
            ],
            [
                'title' => 'B.Tech Admission Process 2026',
                'date' => '2026-01-05',
                'author' => 'Eduspray Team',
                'content' => 'Complete guide to B.Tech admission process, important dates, and eligibility criteria for 2026 academic year.'
            ]
        ]
    ],
    
    'bba' => [
        'name' => 'BBA',
        'full_name' => 'Bachelor of Business Administration',
        'icon' => 'fas fa-briefcase',
        'duration' => '3 Years',
        'avg_fees' => '₹50,000 - ₹3,00,000 per year',
        'short_description' => 'BBA is a bachelor\'s degree in business administration that prepares students for managerial roles across industries.',
        'description' => '
            <p>Bachelor of Business Administration (BBA) is a 3-year undergraduate program that provides comprehensive knowledge of business management principles and practices. It\'s ideal for students who aspire to build careers in corporate management, entrepreneurship, or pursue MBA.</p>
            
            <h4>Why Choose BBA?</h4>
            <ul>
                <li><strong>Strong Foundation:</strong> Excellent preparation for MBA programs</li>
                <li><strong>Practical Skills:</strong> Focus on real-world business applications</li>
                <li><strong>Leadership Development:</strong> Groom future business leaders</li>
                <li><strong>Networking:</strong> Connect with industry professionals early</li>
                <li><strong>Entrepreneurship:</strong> Learn to start and manage your own business</li>
            </ul>
            
            <h4>Key Subjects</h4>
            <div class="specializations-grid">
                <span class="spec-tag">Business Economics</span>
                <span class="spec-tag">Marketing Management</span>
                <span class="spec-tag">Financial Accounting</span>
                <span class="spec-tag">Human Resource Management</span>
                <span class="spec-tag">Business Law</span>
                <span class="spec-tag">Operations Management</span>
            </div>
        ',
        'eligibility' => '
            <h4>Academic Requirements</h4>
            <ul>
                <li>10+2 from any recognized board (Commerce/Science/Arts)</li>
                <li>Minimum 50-60% aggregate marks (varies by institution)</li>
                <li>Mathematics/Accountancy background preferred but not mandatory</li>
            </ul>
            
            <h4>Entrance Exams</h4>
            <ul>
                <li><strong>IPU CET BBA:</strong> For GGSIPU affiliated colleges</li>
                <li><strong>DU JAT:</strong> Delhi University Joint Admission Test</li>
                <li><strong>NPAT:</strong> Narsee Monjee Institute entrance</li>
                <li><strong>SET:</strong> Symbiosis Entrance Test</li>
                <li><strong>CUET:</strong> Common University Entrance Test</li>
            </ul>
        ',
        'career_options' => '
            <h4>Top Career Paths</h4>
            <div class="career-grid">
                <div class="career-card">
                    <i class="fas fa-bullhorn"></i>
                    <h5>Marketing Manager</h5>
                    <p>₹5-15 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-chart-line"></i>
                    <h5>Business Analyst</h5>
                    <p>₹6-18 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-users"></i>
                    <h5>HR Manager</h5>
                    <p>₹5-12 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-money-bill-wave"></i>
                    <h5>Finance Executive</h5>
                    <p>₹4-10 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-handshake"></i>
                    <h5>Sales Manager</h5>
                    <p>₹5-15 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-lightbulb"></i>
                    <h5>Entrepreneur</h5>
                    <p>Unlimited</p>
                </div>
            </div>
            
            <h4>Top Recruiters</h4>
            <p>Deloitte, KPMG, EY, PwC, HDFC Bank, ICICI, Amazon, Flipkart, Reliance, HUL, P&G, and many more MNCs.</p>
            
            <h4>Higher Studies Options</h4>
            <ul>
                <li><strong>MBA:</strong> Master of Business Administration for advanced management roles</li>
                <li><strong>PGDM:</strong> Post Graduate Diploma in Management</li>
                <li><strong>Specialized Masters:</strong> M.Com, M.Fin, M.HRM</li>
                <li><strong>Professional Courses:</strong> CA, CS, CMA alongside or after BBA</li>
            </ul>
        ',
        'syllabus' => '
            <h4>BBA Syllabus Overview</h4>
            <p>The BBA curriculum is divided into 6 semesters over 3 years, covering all aspects of business management.</p>
            
            <h4>First Year (Semesters 1-2)</h4>
            <ul>
                <li><strong>Business Economics:</strong> Micro and macro economics, market structures</li>
                <li><strong>Financial Accounting:</strong> Principles of accounting, financial statements</li>
                <li><strong>Business Mathematics:</strong> Statistics, quantitative methods</li>
                <li><strong>Business Communication:</strong> Written and oral communication skills</li>
                <li><strong>Principles of Management:</strong> Management theories and practices</li>
                <li><strong>Computer Applications:</strong> MS Office, business software</li>
            </ul>
            
            <h4>Second Year (Semesters 3-4)</h4>
            <ul>
                <li><strong>Marketing Management:</strong> Marketing principles, strategies, consumer behavior</li>
                <li><strong>Human Resource Management:</strong> Recruitment, training, performance management</li>
                <li><strong>Financial Management:</strong> Financial planning, investment decisions</li>
                <li><strong>Operations Management:</strong> Production, supply chain, quality management</li>
                <li><strong>Business Law:</strong> Contract law, company law, labor laws</li>
                <li><strong>Organizational Behavior:</strong> Individual and group behavior in organizations</li>
            </ul>
            
            <h4>Third Year (Semesters 5-6)</h4>
            <ul>
                <li><strong>Strategic Management:</strong> Business strategy, competitive analysis</li>
                <li><strong>International Business:</strong> Global business environment, trade</li>
                <li><strong>Entrepreneurship:</strong> Starting and managing businesses</li>
                <li><strong>Business Research Methods:</strong> Research methodology, data analysis</li>
                <li><strong>Elective Subjects:</strong> Specialization in chosen area</li>
                <li><strong>Internship/Project:</strong> Industry training or research project</li>
            </ul>
        ',
        'preparation_tips' => '
            <h4>How to Prepare for BBA Entrance Exams</h4>
            
            <h4>1. Understanding Entrance Exams</h4>
            <p>BBA entrance exams typically test:</p>
            <ul>
                <li><strong>English:</strong> Grammar, vocabulary, comprehension</li>
                <li><strong>Mathematics:</strong> Basic math, algebra, statistics</li>
                <li><strong>Logical Reasoning:</strong> Analytical and logical thinking</li>
                <li><strong>General Knowledge:</strong> Current affairs, business awareness</li>
            </ul>
            
            <h4>2. Preparation Strategy</h4>
            <ul>
                <li>Focus on English and Mathematics fundamentals</li>
                <li>Practice logical reasoning daily</li>
                <li>Stay updated with current affairs and business news</li>
                <li>Take regular mock tests</li>
                <li>Time management is crucial</li>
            </ul>
        ',
        'mock_tests' => '
            <h4>Mock Test Series for BBA Entrance Exams</h4>
            <p>Regular practice with mock tests helps in understanding exam pattern and improving performance.</p>
            
            <h4>Where to Find Mock Tests</h4>
            <ul>
                <li>Official university websites</li>
                <li>Coaching institutes</li>
                <li>Online platforms: Embibe, Unacademy, Vedantu</li>
                <li>Previous year papers</li>
            </ul>
        ',
        'question_papers' => '
            <h4>Previous Year Question Papers</h4>
            <p>Solving previous year papers helps understand exam pattern and important topics.</p>
            
            <h4>Where to Find Question Papers</h4>
            <ul>
                <li>Official university websites</li>
                <li>Coaching institutes</li>
                <li>Books: Arihant, Disha compilation books</li>
                <li>Online platforms</li>
            </ul>
        ',
        'study_material' => '
            <h4>Study Material for BBA Entrance Exams</h4>
            
            <h4>Recommended Books</h4>
            <ul>
                <li><strong>Mathematics:</strong> RS Aggarwal, RD Sharma</li>
                <li><strong>English:</strong> Wren & Martin, Objective English</li>
                <li><strong>Reasoning:</strong> RS Aggarwal</li>
                <li><strong>General Knowledge:</strong> Lucent\'s GK, Manorama Yearbook</li>
            </ul>
            
            <h4>Online Resources</h4>
            <ul>
                <li>Video lectures on Unacademy, Vedantu</li>
                <li>Practice platforms: Embibe, Toppr</li>
                <li>Current affairs apps and websites</li>
            </ul>
        ',
        'faqs' => '
            <h4>Frequently Asked Questions (FAQs)</h4>
            
            <div class="faq-item">
                <h4>Q1. What is the difference between BBA and B.Com?</h4>
                <p><strong>A:</strong> BBA focuses on management and business administration, while B.Com focuses on commerce, accounting, and finance. BBA is more management-oriented, B.Com is more finance-oriented.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q2. Is BBA necessary for MBA?</h4>
                <p><strong>A:</strong> No, BBA is not necessary for MBA. Students from any stream can pursue MBA. However, BBA provides excellent foundation and preparation for MBA programs.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q3. What is the average salary after BBA?</h4>
                <p><strong>A:</strong> Average starting salary ranges from ₹3-6 LPA. With MBA, salaries can reach ₹8-20 LPA or higher. Top BBA colleges see better placement opportunities.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q4. Can I do BBA without Mathematics?</h4>
                <p><strong>A:</strong> Yes, most BBA programs don\'t require Mathematics in 12th. However, basic mathematical aptitude is helpful for the course and entrance exams.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q5. What are the specializations in BBA?</h4>
                <p><strong>A:</strong> Common specializations include Marketing, Finance, Human Resources, Operations, International Business, and Entrepreneurship.</p>
            </div>
        ',
        'key_info' => [
            'Duration' => '3 Years (6 Semesters)',
            'Total Marks' => 'Varies by University',
            'Exam Pattern' => 'Entrance Exam Based (varies by university)',
            'Languages' => 'English',
            'No. of Attempts' => 'Varies by exam',
            'Application Fee' => '₹500 - ₹2,000',
            'Colleges Available' => '1000+ colleges in India',
            'Top Colleges' => 'DU, IPU, Symbiosis, Christ University, Amity',
            'Average Fees' => '₹50,000 - ₹3,00,000 per year',
            'Higher Studies' => 'MBA, PGDM, M.Com'
        ],
        'specializations' => [
            'Marketing' => 'MKT',
            'Finance' => 'FIN',
            'Human Resource Management' => 'HRM',
            'Operations Management' => 'OM',
            'International Business' => 'IB',
            'Entrepreneurship' => 'ENT',
            'Information Technology' => 'IT',
            'Retail Management' => 'RM'
        ],
        'updates' => [
            [
                'title' => 'BBA Admission 2026 - Application Forms Open',
                'date' => '2026-01-15',
                'author' => 'Eduspray Team',
                'content' => 'BBA admission applications are now open for 2026 academic year. Check out top colleges and their admission procedures.'
            ],
            [
                'title' => 'New BBA Colleges Added - 100+ Programs Available',
                'date' => '2026-01-10',
                'author' => 'Eduspray Team',
                'content' => 'We have added 100+ new BBA programs to our database. Explore the latest options for business administration education.'
            ]
        ]
    ],
    
    'bca' => [
        'name' => 'BCA',
        'full_name' => 'Bachelor of Computer Applications',
        'icon' => 'fas fa-laptop-code',
        'duration' => '3 Years',
        'avg_fees' => '₹40,000 - ₹2,00,000 per year',
        'short_description' => 'BCA is an undergraduate degree focusing on computer applications, programming, and software development.',
        'description' => '
            <p>Bachelor of Computer Applications (BCA) is a 3-year undergraduate program designed for students who want to pursue a career in IT and software development. It provides foundational knowledge in programming, databases, networking, and web development.</p>
            
            <h4>Why Choose BCA?</h4>
            <ul>
                <li><strong>IT Industry Ready:</strong> Practical programming skills for immediate employment</li>
                <li><strong>Cost-Effective:</strong> Shorter duration and lower fees than B.Tech</li>
                <li><strong>Flexibility:</strong> Open to students from any stream</li>
                <li><strong>MCA Path:</strong> Gateway to MCA for advanced IT careers</li>
                <li><strong>Growing Demand:</strong> IT sector always needs skilled programmers</li>
            </ul>
            
            <h4>Key Technologies Covered</h4>
            <div class="specializations-grid">
                <span class="spec-tag">Java Programming</span>
                <span class="spec-tag">Python</span>
                <span class="spec-tag">Web Development</span>
                <span class="spec-tag">Database Management</span>
                <span class="spec-tag">Data Structures</span>
                <span class="spec-tag">Cloud Computing</span>
            </div>
        ',
        'eligibility' => '
            <h4>Academic Requirements</h4>
            <ul>
                <li>10+2 from any recognized board</li>
                <li>Minimum 50% aggregate marks</li>
                <li>Mathematics in 12th (required by most colleges)</li>
                <li>English as a subject in 12th</li>
            </ul>
            
            <h4>Entrance Exams</h4>
            <ul>
                <li><strong>IPU CET BCA:</strong> For IPU affiliated colleges in Delhi</li>
                <li><strong>CUET:</strong> Common University Entrance Test</li>
                <li><strong>Symbiosis SET:</strong> For Symbiosis institutes</li>
                <li><strong>Christ University Entrance:</strong> For Christ University</li>
            </ul>
        ',
        'career_options' => '
            <h4>Top Career Paths</h4>
            <div class="career-grid">
                <div class="career-card">
                    <i class="fas fa-code"></i>
                    <h5>Software Developer</h5>
                    <p>₹4-12 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-globe"></i>
                    <h5>Web Developer</h5>
                    <p>₹3-10 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-mobile-alt"></i>
                    <h5>App Developer</h5>
                    <p>₹4-15 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-database"></i>
                    <h5>Database Admin</h5>
                    <p>₹4-12 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-headset"></i>
                    <h5>Technical Support</h5>
                    <p>₹3-8 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-bug"></i>
                    <h5>Software Tester</h5>
                    <p>₹3-10 LPA</p>
                </div>
            </div>
            
            <h4>Top Recruiters</h4>
            <p>TCS, Infosys, Wipro, HCL, Accenture, IBM, Cognizant, Capgemini, Tech Mahindra, Microsoft, Google, Amazon, and leading IT companies.</p>
            
            <h4>Higher Studies Options</h4>
            <ul>
                <li><strong>MCA (Master of Computer Applications):</strong> Advanced specialization in computer applications</li>
                <li><strong>M.Tech:</strong> For technical specialization (requires B.Tech or equivalent)</li>
                <li><strong>MBA:</strong> For management roles in IT industry</li>
                <li><strong>Professional Certifications:</strong> Oracle, Microsoft, AWS, Google Cloud certifications</li>
            </ul>
        ',
        'syllabus' => '
            <h4>BCA Syllabus Overview</h4>
            <p>The BCA curriculum is divided into 6 semesters over 3 years, covering programming, databases, networking, and software development.</p>
            
            <h4>First Year (Semesters 1-2)</h4>
            <ul>
                <li><strong>Programming Fundamentals:</strong> C/C++ programming, data types, control structures</li>
                <li><strong>Mathematics:</strong> Discrete Mathematics, Statistics, Calculus</li>
                <li><strong>Computer Fundamentals:</strong> Computer organization, operating systems basics</li>
                <li><strong>Web Technologies:</strong> HTML, CSS, JavaScript basics</li>
                <li><strong>Database Management:</strong> Introduction to DBMS, SQL</li>
                <li><strong>Communication Skills:</strong> English, technical writing</li>
            </ul>
            
            <h4>Second Year (Semesters 3-4)</h4>
            <ul>
                <li><strong>Object-Oriented Programming:</strong> Java, C++, OOP concepts</li>
                <li><strong>Data Structures:</strong> Arrays, linked lists, stacks, queues, trees</li>
                <li><strong>Database Systems:</strong> Advanced SQL, database design, normalization</li>
                <li><strong>Web Development:</strong> PHP, ASP.NET, server-side scripting</li>
                <li><strong>Computer Networks:</strong> Network protocols, TCP/IP, LAN/WAN</li>
                <li><strong>Software Engineering:</strong> SDLC, software design, testing</li>
            </ul>
            
            <h4>Third Year (Semesters 5-6)</h4>
            <ul>
                <li><strong>Advanced Programming:</strong> Python, .NET, advanced Java</li>
                <li><strong>Mobile Application Development:</strong> Android, iOS development</li>
                <li><strong>Cloud Computing:</strong> AWS, Azure, cloud services</li>
                <li><strong>Project Management:</strong> Agile, Scrum, project planning</li>
                <li><strong>Elective Subjects:</strong> AI/ML, Data Science, Cybersecurity, etc.</li>
                <li><strong>Final Year Project:</strong> Software development project</li>
            </ul>
        ',
        'preparation_tips' => '
            <h4>How to Prepare for BCA Entrance Exams</h4>
            
            <h4>1. Understanding Entrance Exams</h4>
            <p>BCA entrance exams typically test:</p>
            <ul>
                <li><strong>Mathematics:</strong> Basic math, algebra, geometry, statistics</li>
                <li><strong>English:</strong> Grammar, vocabulary, comprehension</li>
                <li><strong>Logical Reasoning:</strong> Analytical and logical thinking</li>
                <li><strong>General Knowledge:</strong> Current affairs, general awareness</li>
                <li><strong>Computer Awareness:</strong> Basic computer knowledge (for some exams)</li>
            </ul>
            
            <h4>2. Preparation Strategy</h4>
            <ul>
                <li><strong>Mathematics:</strong> Focus on basics, practice regularly</li>
                <li><strong>English:</strong> Improve vocabulary, practice reading comprehension</li>
                <li><strong>Reasoning:</strong> Practice logical reasoning questions daily</li>
                <li><strong>GK:</strong> Stay updated with current affairs</li>
                <li><strong>Mock Tests:</strong> Take regular mock tests</li>
            </ul>
            
            <h4>3. Recommended Study Schedule</h4>
            <ul>
                <li>Allocate 2-3 hours daily for preparation</li>
                <li>Focus on weak areas</li>
                <li>Take weekly mock tests</li>
                <li>Revise regularly</li>
            </ul>
        ',
        'mock_tests' => '
            <h4>Mock Test Series for BCA Entrance Exams</h4>
            <p>Regular practice with mock tests helps in understanding exam pattern and improving performance.</p>
            
            <h4>Where to Find Mock Tests</h4>
            <ul>
                <li>Official university websites</li>
                <li>Coaching institutes</li>
                <li>Online platforms: Embibe, Unacademy, Vedantu</li>
                <li>Previous year papers</li>
            </ul>
        ',
        'question_papers' => '
            <h4>Previous Year Question Papers</h4>
            <p>Solving previous year papers helps understand exam pattern and important topics.</p>
            
            <h4>Where to Find Question Papers</h4>
            <ul>
                <li>Official university websites</li>
                <li>Coaching institutes</li>
                <li>Books: Arihant, Disha compilation books</li>
                <li>Online platforms</li>
            </ul>
        ',
        'study_material' => '
            <h4>Study Material for BCA Entrance Exams</h4>
            
            <h4>Recommended Books</h4>
            <ul>
                <li><strong>Mathematics:</strong> RS Aggarwal, RD Sharma</li>
                <li><strong>English:</strong> Wren & Martin, Objective English</li>
                <li><strong>Reasoning:</strong> RS Aggarwal</li>
                <li><strong>General Knowledge:</strong> Lucent\'s GK, Manorama Yearbook</li>
            </ul>
            
            <h4>Online Resources</h4>
            <ul>
                <li>Video lectures on Unacademy, Vedantu</li>
                <li>Practice platforms: Embibe, Toppr</li>
                <li>Current affairs apps and websites</li>
            </ul>
        ',
        'faqs' => '
            <h4>Frequently Asked Questions (FAQs)</h4>
            
            <div class="faq-item">
                <h4>Q1. What is the difference between BCA and B.Tech Computer Science?</h4>
                <p><strong>A:</strong> BCA focuses on computer applications and software development, while B.Tech CS is more engineering-oriented with deeper technical knowledge. BCA is 3 years, B.Tech is 4 years. Both lead to similar career paths in IT.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q2. Is Mathematics mandatory for BCA?</h4>
                <p><strong>A:</strong> Most colleges require Mathematics in 12th for BCA admission. However, some colleges may accept students without Mathematics. Check specific college requirements.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q3. Can I do MCA after BCA?</h4>
                <p><strong>A:</strong> Yes, BCA graduates can pursue MCA (Master of Computer Applications) for advanced specialization. MCA is a 2-3 year program.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q4. What is the average salary after BCA?</h4>
                <p><strong>A:</strong> Average starting salary ranges from ₹3-6 LPA. With experience and skills, salaries can reach ₹10-20 LPA or higher in top IT companies.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q5. What programming languages are taught in BCA?</h4>
                <p><strong>A:</strong> BCA typically covers C, C++, Java, Python, PHP, JavaScript, and web technologies like HTML, CSS, and database management systems.</p>
            </div>
        ',
        'key_info' => [
            'Duration' => '3 Years (6 Semesters)',
            'Total Marks' => 'Varies by University',
            'Exam Pattern' => 'Entrance Exam Based (varies by university)',
            'Languages' => 'English',
            'No. of Attempts' => 'Varies by exam',
            'Application Fee' => '₹500 - ₹2,000',
            'Colleges Available' => '500+ colleges in India',
            'Top Colleges' => 'Christ University, Symbiosis, IPU, DU, Amity',
            'Average Fees' => '₹40,000 - ₹2,00,000 per year',
            'Higher Studies' => 'MCA, M.Tech, MBA'
        ],
        'specializations' => [
            'Software Development' => 'SD',
            'Web Development' => 'WD',
            'Mobile App Development' => 'MAD',
            'Database Management' => 'DBM',
            'Cloud Computing' => 'CC',
            'Data Science' => 'DS',
            'Cybersecurity' => 'CS',
            'Artificial Intelligence' => 'AI'
        ],
        'updates' => [
            [
                'title' => 'BCA Admission 2026 - Application Forms Open',
                'date' => '2026-01-15',
                'author' => 'Eduspray Team',
                'content' => 'BCA admission applications are now open for 2026 academic year. Check out top colleges and their admission procedures.'
            ],
            [
                'title' => 'New BCA Colleges Added - 50+ Programs Available',
                'date' => '2026-01-10',
                'author' => 'Eduspray Team',
                'content' => 'We have added 50+ new BCA programs to our database. Explore the latest options for computer applications education.'
            ]
        ]
    ],
    
    'medical' => [
        'name' => 'Medical',
        'full_name' => 'Medical Sciences (MBBS, BDS, BAMS, etc.)',
        'icon' => 'fas fa-stethoscope',
        'duration' => '4.5 - 5.5 Years',
        'avg_fees' => '₹50,000 - ₹25,00,000 per year',
        'short_description' => 'Medical courses prepare students for healthcare careers including doctors, dentists, and specialists.',
        'description' => '
            <p>Medical sciences offer some of the most respected and rewarding career paths. From MBBS to specialized medical courses, healthcare education prepares students to save lives and improve public health.</p>
            
            <h4>Why Choose Medical?</h4>
            <ul>
                <li><strong>Noble Profession:</strong> Directly impact and save lives</li>
                <li><strong>High Respect:</strong> Doctors are highly respected in society</li>
                <li><strong>Job Security:</strong> Healthcare demand never decreases</li>
                <li><strong>Excellent Earning:</strong> High salary potential with specialization</li>
                <li><strong>Global Opportunities:</strong> Practice medicine worldwide</li>
            </ul>
            
            <h4>Medical Courses</h4>
            <div class="specializations-grid">
                <span class="spec-tag">MBBS</span>
                <span class="spec-tag">BDS (Dentistry)</span>
                <span class="spec-tag">BAMS (Ayurveda)</span>
                <span class="spec-tag">BHMS (Homeopathy)</span>
                <span class="spec-tag">B.Pharm</span>
                <span class="spec-tag">Nursing</span>
            </div>
        ',
        'eligibility' => '
            <h4>Academic Requirements</h4>
            <ul>
                <li>10+2 with Physics, Chemistry, and Biology (PCB)</li>
                <li>Minimum 50% aggregate (40% for reserved categories)</li>
                <li>Age: 17-25 years at the time of admission</li>
            </ul>
            
            <h4>Entrance Exams</h4>
            <ul>
                <li><strong>NEET-UG:</strong> National Eligibility cum Entrance Test (Mandatory for all medical courses)</li>
                <li><strong>AIIMS:</strong> Now merged with NEET</li>
                <li><strong>State Counselling:</strong> Based on NEET scores</li>
            </ul>
        ',
        'career_options' => '
            <h4>Top Career Paths</h4>
            <div class="career-grid">
                <div class="career-card">
                    <i class="fas fa-user-md"></i>
                    <h5>Doctor/Physician</h5>
                    <p>₹8-50 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-tooth"></i>
                    <h5>Dentist</h5>
                    <p>₹5-25 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-heartbeat"></i>
                    <h5>Surgeon</h5>
                    <p>₹15-80 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-pills"></i>
                    <h5>Pharmacist</h5>
                    <p>₹3-12 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-hospital"></i>
                    <h5>Hospital Admin</h5>
                    <p>₹6-20 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-microscope"></i>
                    <h5>Medical Researcher</h5>
                    <p>₹5-25 LPA</p>
                </div>
            </div>
            
            <h4>Top Recruiters</h4>
            <p>Government hospitals, private hospitals (Apollo, Fortis, Max, AIIMS), pharmaceutical companies, research institutes, and healthcare organizations.</p>
            
            <h4>Higher Studies Options</h4>
            <ul>
                <li><strong>MD/MS:</strong> Doctor of Medicine/Master of Surgery for specialization</li>
                <li><strong>DM/MCh:</strong> Super-specialization courses</li>
                <li><strong>PhD:</strong> For research careers</li>
                <li><strong>International Programs:</strong> USMLE, PLAB for practice abroad</li>
            </ul>
        ',
        'syllabus' => '
            <h4>Medical Courses Syllabus Overview</h4>
            <p>Medical courses vary by program (MBBS, BDS, BAMS, etc.) but generally cover comprehensive healthcare education.</p>
            
            <h4>MBBS Syllabus (5.5 Years)</h4>
            <ul>
                <li><strong>Pre-Clinical (1.5 years):</strong> Anatomy, Physiology, Biochemistry</li>
                <li><strong>Para-Clinical (1.5 years):</strong> Pathology, Pharmacology, Microbiology, Forensic Medicine</li>
                <li><strong>Clinical (2.5 years):</strong> Medicine, Surgery, Obstetrics & Gynecology, Pediatrics, Community Medicine</li>
                <li><strong>Internship (1 year):</strong> Rotating internship in various departments</li>
            </ul>
            
            <h4>BDS Syllabus (5 Years)</h4>
            <ul>
                <li>Dental Anatomy, Oral Pathology, Periodontics, Orthodontics, Oral Surgery, Prosthodontics</li>
                <li>Clinical training in dental procedures</li>
            </ul>
        ',
        'preparation_tips' => '
            <h4>How to Prepare for NEET-UG</h4>
            
            <h4>1. Understanding NEET-UG</h4>
            <p>NEET-UG is the mandatory entrance exam for all medical courses in India. It tests:</p>
            <ul>
                <li><strong>Physics:</strong> 45 questions (180 marks)</li>
                <li><strong>Chemistry:</strong> 45 questions (180 marks)</li>
                <li><strong>Biology:</strong> 90 questions (360 marks)</li>
                <li>Total: 720 marks, 3 hours duration</li>
            </ul>
            
            <h4>2. Preparation Strategy</h4>
            <ul>
                <li>Focus on NCERT books for strong foundation</li>
                <li>Practice previous year papers and mock tests</li>
                <li>Time management is crucial</li>
                <li>Regular revision is essential</li>
            </ul>
        ',
        'mock_tests' => '
            <h4>Mock Test Series for NEET-UG</h4>
            <p>Regular practice with mock tests is essential for NEET-UG success.</p>
            
            <h4>Where to Find Mock Tests</h4>
            <ul>
                <li>Official NTA mock tests</li>
                <li>Coaching institutes: Aakash, Allen, FIITJEE, Resonance</li>
                <li>Online platforms: Embibe, Unacademy, Vedantu</li>
            </ul>
        ',
        'question_papers' => '
            <h4>Previous Year NEET-UG Papers</h4>
            <p>Solving previous year papers helps understand exam pattern and important topics.</p>
            
            <h4>Where to Find Question Papers</h4>
            <ul>
                <li>Official NTA website</li>
                <li>Coaching institutes</li>
                <li>Books: Arihant, Disha compilation books</li>
            </ul>
        ',
        'study_material' => '
            <h4>Study Material for NEET-UG</h4>
            
            <h4>Recommended Books</h4>
            <ul>
                <li><strong>NCERT:</strong> Class 11 & 12 Physics, Chemistry, Biology (essential)</li>
                <li><strong>Physics:</strong> HC Verma, DC Pandey</li>
                <li><strong>Chemistry:</strong> OP Tandon, MS Chouhan</li>
                <li><strong>Biology:</strong> Trueman\'s Biology, MTG Biology</li>
            </ul>
        ',
        'faqs' => '
            <h4>Frequently Asked Questions (FAQs)</h4>
            
            <div class="faq-item">
                <h4>Q1. What is a good NEET score for MBBS admission?</h4>
                <p><strong>A:</strong> Score above 600: Top medical colleges. Score 500-600: Good medical colleges. Score 400-500: Decent medical colleges. Cutoff varies by state and category.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q2. Is NEET mandatory for all medical courses?</h4>
                <p><strong>A:</strong> Yes, NEET-UG is mandatory for admission to MBBS, BDS, BAMS, BHMS, and other medical courses in India.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q3. What is the age limit for NEET?</h4>
                <p><strong>A:</strong> Minimum age: 17 years. Maximum age: 25 years (30 years for reserved categories).</p>
            </div>
            
            <div class="faq-item">
                <h4>Q4. How many attempts are allowed for NEET?</h4>
                <p><strong>A:</strong> There is no limit on the number of attempts for NEET-UG, subject to age limit.</p>
            </div>
        ',
        'key_info' => [
            'Duration (MBBS)' => '5.5 Years (including 1 year internship)',
            'Duration (BDS)' => '5 Years (including 1 year internship)',
            'Total Marks (NEET-UG)' => '720 marks',
            'Exam Pattern (NEET-UG)' => 'Physics (45), Chemistry (45), Biology (90)',
            'Languages' => 'English, Hindi, and regional languages',
            'No. of Attempts' => 'Unlimited (subject to age limit)',
            'Application Fee (NEET-UG)' => '₹1,700 (General), ₹1,600 (OBC), ₹1,000 (SC/ST/PWD)',
            'Official Website (NEET-UG)' => 'neet.nta.nic.in',
            'Colleges Available' => '600+ medical colleges in India',
            'Top Colleges' => 'AIIMS, JIPMER, CMC Vellore, Maulana Azad Medical College',
            'Average Fees' => '₹50,000 - ₹25,00,000 per year'
        ],
        'specializations' => [
            'MBBS' => 'MBBS',
            'BDS (Dentistry)' => 'BDS',
            'BAMS (Ayurveda)' => 'BAMS',
            'BHMS (Homeopathy)' => 'BHMS',
            'B.Pharm (Pharmacy)' => 'B.Pharm',
            'BPT (Physiotherapy)' => 'BPT',
            'B.Sc Nursing' => 'NURS',
            'BVSc (Veterinary)' => 'BVSc'
        ],
        'updates' => [
            [
                'title' => 'NEET-UG 2026 Registration Open - Apply Now for Medical Admission',
                'date' => '2026-01-15',
                'author' => 'Eduspray Team',
                'content' => 'NEET-UG 2026 registration is now open. Candidates can apply through the official NTA website for admission to medical courses.'
            ],
            [
                'title' => 'Medical Admission 2026 - Complete Guide Released',
                'date' => '2026-01-12',
                'author' => 'Eduspray Team',
                'content' => 'Complete guide to medical admission process, important dates, eligibility criteria, and counseling procedures for 2026.'
            ]
        ]
    ],
    
    'barch' => [
        'name' => 'B.Arch',
        'full_name' => 'Bachelor of Architecture',
        'icon' => 'fas fa-building',
        'duration' => '5 Years',
        'avg_fees' => '₹1,00,000 - ₹3,50,000 per year',
        'short_description' => 'B.Arch is a 5-year professional degree program that combines creativity with technical knowledge to train students in architectural design, planning, and construction.',
        'description' => '
            <p>Bachelor of Architecture (B.Arch) is a 5-year professional degree program that trains students in architectural design, planning, and construction. It combines creativity with technical knowledge to create functional and aesthetically pleasing built environments.</p>
            
            <h4>Why Choose B.Arch?</h4>
            <ul>
                <li><strong>Creative Career:</strong> Design iconic buildings and spaces that shape the world</li>
                <li><strong>High Demand:</strong> Infrastructure development and urbanization driving growth</li>
                <li><strong>Entrepreneurship:</strong> Start your own architectural firm and be your own boss</li>
                <li><strong>Global Practice:</strong> Work on international projects and travel opportunities</li>
                <li><strong>Diverse Opportunities:</strong> From residential to commercial, sustainable to heritage conservation</li>
                <li><strong>Professional Recognition:</strong> Register with Council of Architecture (COA) after graduation</li>
            </ul>
            
            <h4>Skills Developed</h4>
            <div class="specializations-grid">
                <span class="spec-tag">Analytical Thinking</span>
                <span class="spec-tag">Communication Skills</span>
                <span class="spec-tag">Creativity & Innovation</span>
                <span class="spec-tag">Organizational Skills</span>
                <span class="spec-tag">Visualization</span>
                <span class="spec-tag">Technical Drawing</span>
                <span class="spec-tag">3D Modeling</span>
                <span class="spec-tag">Project Management</span>
            </div>
            
            <h4>Program Structure</h4>
            <p>The B.Arch program is divided into 10 semesters over 5 years, including:</p>
            <ul>
                <li>Core architectural design studios</li>
                <li>Theory courses in history, building science, and planning</li>
                <li>Technical courses in construction and materials</li>
                <li>Computer-aided design and software training</li>
                <li>Workshop practice and hands-on training</li>
                <li>Site visits and field studies</li>
                <li>Internship/training in architectural firms</li>
                <li>Final year thesis project</li>
            </ul>
        ',
        'eligibility' => '
            <h4>Academic Requirements</h4>
            <ul>
                <li><strong>10+2 Qualification:</strong> Passed 10+2 or equivalent examination with Mathematics as a compulsory subject</li>
                <li><strong>Minimum Marks:</strong> 50% aggregate marks (45% for SC/ST/OBC categories)</li>
                <li><strong>Alternative Qualification:</strong> 10+3 Diploma with Mathematics as compulsory subject and minimum 50% aggregate marks</li>
                <li><strong>Age Limit:</strong> No upper age limit (varies by institution)</li>
            </ul>
            
            <h4>Entrance Exams</h4>
            <p>Admission to B.Arch programs requires valid scores in one of the following entrance exams:</p>
            <ul>
                <li><strong>NATA (National Aptitude Test in Architecture):</strong>
                    <ul>
                        <li>Conducted by Council of Architecture (COA)</li>
                        <li>Accepted by most architecture colleges in India</li>
                        <li>Tests drawing skills, observation, sense of proportion, aesthetic sensitivity, and critical thinking</li>
                        <li>Multiple attempts allowed in a year</li>
                        <li>Official website: nata.in</li>
                    </ul>
                </li>
                <li><strong>JEE Main Paper 2:</strong>
                    <ul>
                        <li>Conducted by National Testing Agency (NTA)</li>
                        <li>Required for admission to NITs, IIITs, and centrally funded architecture institutes</li>
                        <li>Includes Mathematics, Aptitude Test, and Drawing Test</li>
                        <li>Conducted twice a year (January and April sessions)</li>
                        <li>Official website: jeemain.nta.nic.in</li>
                    </ul>
                </li>
            </ul>
            
            <h4>State-Level Exams</h4>
            <ul>
                <li><strong>UPTAC:</strong> Uttar Pradesh Technical Admission Counseling</li>
                <li><strong>AP B.Arch:</strong> Andhra Pradesh State Council of Higher Education</li>
                <li><strong>TS B.Arch:</strong> Telangana State Council of Higher Education</li>
                <li><strong>KEAM:</strong> Kerala Engineering Architecture Medical entrance exam</li>
            </ul>
        ',
        'career_options' => '
            <h4>Top Career Paths</h4>
            <div class="career-grid">
                <div class="career-card">
                    <i class="fas fa-pencil-ruler"></i>
                    <h5>Design Architect</h5>
                    <p>₹3.45 - ₹8 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-building"></i>
                    <h5>Project Architect</h5>
                    <p>₹5.48 - ₹12 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-city"></i>
                    <h5>Urban Planner</h5>
                    <p>₹5.46 - ₹15 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-couch"></i>
                    <h5>Interior Architect</h5>
                    <p>₹4.81 - ₹12 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-tree"></i>
                    <h5>Landscape Architect</h5>
                    <p>₹5 - ₹15 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-leaf"></i>
                    <h5>Sustainable Architect</h5>
                    <p>₹6 - ₹18 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-monument"></i>
                    <h5>Heritage Conservation Architect</h5>
                    <p>₹5 - ₹14 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-industry"></i>
                    <h5>Industrial Architect</h5>
                    <p>₹6 - ₹16 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-chart-line"></i>
                    <h5>Senior Project Architect</h5>
                    <p>₹9.89 - ₹25 LPA</p>
                </div>
            </div>
            
            <h4>Top Recruiters</h4>
            <p>L&T Construction, Shapoorji Pallonji, Tata Consulting Engineers, HOK, Perkins+Will, Gensler, AECOM, Foster + Partners, Zaha Hadid Architects, Skidmore, Owings & Merrill (SOM), and leading architectural firms across India and globally.</p>
            
            <h4>Higher Studies Options</h4>
            <ul>
                <li><strong>M.Arch (Master of Architecture):</strong> Specialization in Urban Design, Landscape Architecture, Sustainable Architecture, etc.</li>
                <li><strong>MBA:</strong> For management roles in construction and real estate</li>
                <li><strong>PhD in Architecture:</strong> For research and academic careers</li>
                <li><strong>International Programs:</strong> M.Arch from top universities abroad (USA, UK, Germany, etc.)</li>
            </ul>
            
            <h4>Entrepreneurship</h4>
            <p>Many B.Arch graduates start their own architectural firms, offering services in residential, commercial, and institutional design. With experience and networking, architects can build successful practices.</p>
        ',
        'syllabus' => '
            <h4>B.Arch Syllabus Overview</h4>
            <p>The B.Arch curriculum is divided into 10 semesters over 5 years, covering fundamental architectural principles, design studios, technical subjects, and practical training.</p>
            
            <h4>First Year (Semesters 1-2)</h4>
            <ul>
                <li><strong>Architectural Design:</strong> Introduction to design principles, basic design exercises</li>
                <li><strong>Building Construction:</strong> Basic construction techniques and materials</li>
                <li><strong>Architectural Graphics:</strong> Technical drawing, perspective, rendering</li>
                <li><strong>History of Architecture:</strong> Ancient and medieval architecture</li>
                <li><strong>Mathematics:</strong> Applied mathematics for architecture</li>
                <li><strong>Workshop Practice:</strong> Model making, carpentry, masonry</li>
                <li><strong>Computer Applications:</strong> Basic CAD software introduction</li>
            </ul>
            
            <h4>Second Year (Semesters 3-4)</h4>
            <ul>
                <li><strong>Architectural Design:</strong> Residential and small-scale projects</li>
                <li><strong>Building Construction:</strong> Advanced construction techniques</li>
                <li><strong>History of Architecture:</strong> Modern and contemporary architecture</li>
                <li><strong>Building Materials:</strong> Properties and applications of construction materials</li>
                <li><strong>Climatology:</strong> Climate-responsive design</li>
                <li><strong>Surveying & Leveling:</strong> Site analysis and measurement</li>
                <li><strong>Computer & Software Lab:</strong> AutoCAD, SketchUp, Revit basics</li>
            </ul>
            
            <h4>Third Year (Semesters 5-6)</h4>
            <ul>
                <li><strong>Architectural Design:</strong> Institutional and commercial buildings</li>
                <li><strong>Building Construction:</strong> Advanced structures, RCC, steel structures</li>
                <li><strong>Building Services:</strong> Electrical, plumbing, HVAC systems</li>
                <li><strong>Theory of Structures:</strong> Structural analysis and design principles</li>
                <li><strong>Architectural Appreciation:</strong> Critical analysis of buildings</li>
                <li><strong>Specifications & Estimation:</strong> Cost estimation and specifications</li>
                <li><strong>Site Planning:</strong> Site planning and landscape design</li>
            </ul>
            
            <h4>Fourth Year (Semesters 7-8)</h4>
            <ul>
                <li><strong>Architectural Design:</strong> Large-scale projects, urban design</li>
                <li><strong>Building Management:</strong> Project management and construction management</li>
                <li><strong>Theory of Settlement Planning:</strong> Urban and regional planning</li>
                <li><strong>Professional Practice:</strong> Legal aspects, contracts, ethics</li>
                <li><strong>Elective Subjects:</strong> Specialization in chosen area</li>
                <li><strong>Internship:</strong> 6-8 weeks training in architectural firms</li>
            </ul>
            
            <h4>Fifth Year (Semesters 9-10)</h4>
            <ul>
                <li><strong>Thesis Project:</strong> Independent design project on chosen topic</li>
                <li><strong>Advanced Design Studio:</strong> Complex architectural projects</li>
                <li><strong>Dissertation:</strong> Research paper on architectural topic</li>
                <li><strong>Professional Practice:</strong> Office management, client relations</li>
                <li><strong>Portfolio Development:</strong> Compilation of best work</li>
            </ul>
            
            <h4>Practical Components</h4>
            <ul>
                <li>Design studios with regular critiques and presentations</li>
                <li>Site visits to understand construction and design in context</li>
                <li>Workshop sessions for model making and material exploration</li>
                <li>Computer labs for CAD, 3D modeling, and rendering</li>
                <li>Internship/training in architectural firms (typically 6-8 weeks)</li>
                <li>Final year thesis project with comprehensive documentation</li>
            </ul>
        ',
        'preparation_tips' => '
            <h4>How to Prepare for B.Arch Entrance Exams</h4>
            
            <h4>1. Understanding NATA (National Aptitude Test in Architecture)</h4>
            <p>NATA assesses your aptitude for architecture through:</p>
            <ul>
                <li><strong>Drawing Test:</strong> Tests your ability to sketch, draw, and visualize</li>
                <li><strong>Aesthetic Sensitivity Test:</strong> Tests your sense of proportion, color, and design</li>
                <li><strong>Observation Skills:</strong> Ability to observe and analyze visual elements</li>
            </ul>
            
            <h4>2. NATA Preparation Strategy</h4>
            <ul>
                <li><strong>Drawing Practice:</strong> Practice freehand drawing daily - objects, buildings, perspectives</li>
                <li><strong>Sketching:</strong> Develop skills in pencil sketching, shading, and rendering</li>
                <li><strong>2D & 3D Visualization:</strong> Practice converting 2D plans to 3D views and vice versa</li>
                <li><strong>Color Theory:</strong> Learn about color combinations, harmony, and contrast</li>
                <li><strong>Architectural Awareness:</strong> Study famous buildings, architects, and architectural styles</li>
                <li><strong>Mock Tests:</strong> Take regular NATA mock tests to understand exam pattern</li>
            </ul>
            
            <h4>3. JEE Main Paper 2 Preparation</h4>
            <p>JEE Main Paper 2 consists of three parts:</p>
            <ul>
                <li><strong>Mathematics:</strong> 20 MCQs + 5 numerical questions (25 marks)</li>
                <li><strong>Aptitude Test:</strong> 50 MCQs (200 marks) - visual reasoning, design awareness</li>
                <li><strong>Drawing Test:</strong> 2 questions (100 marks) - sketching and composition</li>
            </ul>
            
            <h4>4. JEE Main Paper 2 Preparation Tips</h4>
            <ul>
                <li><strong>Mathematics:</strong> Focus on Algebra, Calculus, Coordinate Geometry, Trigonometry</li>
                <li><strong>Aptitude:</strong> Practice visual reasoning, pattern recognition, architectural awareness</li>
                <li><strong>Drawing:</strong> Practice perspective drawing, 2D to 3D conversion, composition</li>
                <li><strong>Time Management:</strong> Allocate time wisely - 60 min for Math, 60 min for Aptitude, 60 min for Drawing</li>
                <li><strong>Previous Papers:</strong> Solve last 5-10 years JEE Main Paper 2 question papers</li>
            </ul>
            
            <h4>5. Drawing Test Preparation</h4>
            <ul>
                <li>Practice daily sketching of everyday objects</li>
                <li>Learn perspective drawing (1-point, 2-point, 3-point)</li>
                <li>Practice architectural elements (doors, windows, stairs, roofs)</li>
                <li>Develop skills in shading, rendering, and texture representation</li>
                <li>Study human scale and proportions</li>
                <li>Practice composition and visual balance</li>
            </ul>
            
            <h4>6. Recommended Study Schedule</h4>
            <ul>
                <li><strong>Morning (3-4 hours):</strong> Mathematics practice and theory</li>
                <li><strong>Afternoon (2-3 hours):</strong> Drawing practice and sketching</li>
                <li><strong>Evening (2-3 hours):</strong> Aptitude test practice and architectural awareness</li>
                <li><strong>Weekly:</strong> Take one full-length mock test</li>
                <li><strong>Monthly:</strong> Review progress and adjust strategy</li>
            </ul>
            
            <h4>7. Important Tips</h4>
            <ul>
                <li>Start preparation at least 6-12 months before the exam</li>
                <li>Maintain a sketchbook for daily practice</li>
                <li>Join coaching classes or online courses for structured guidance</li>
                <li>Visit architectural sites and buildings to develop observation skills</li>
                <li>Stay updated with current architectural trends and famous architects</li>
                <li>Practice time-bound drawing exercises to improve speed</li>
            </ul>
        ',
        'mock_tests' => '
            <h4>Mock Test Series for B.Arch Entrance Exams</h4>
            <p>Regular practice with mock tests is essential for success in NATA and JEE Main Paper 2. Here\'s how to make the most of them:</p>
            
            <h4>Benefits of Mock Tests</h4>
            <ul>
                <li>Familiarize yourself with exam pattern and timing</li>
                <li>Identify strengths and weaknesses in different sections</li>
                <li>Improve time management skills</li>
                <li>Build exam-day confidence</li>
                <li>Track your progress over time</li>
                <li>Understand question types and difficulty levels</li>
            </ul>
            
            <h4>NATA Mock Tests</h4>
            <ul>
                <li><strong>Official NATA Mock Tests:</strong> Available on nata.in</li>
                <li><strong>Coaching Institute Tests:</strong> FIITJEE, Allen, Aakash, Bansal Classes</li>
                <li><strong>Online Platforms:</strong> Embibe, Unacademy, Vedantu, BYJU\'S, Gradeup</li>
                <li><strong>Architecture Coaching Centers:</strong> Specialized centers offer NATA-specific mock tests</li>
            </ul>
            
            <h4>JEE Main Paper 2 Mock Tests</h4>
            <ul>
                <li><strong>NTA Official Mock Tests:</strong> Available on jeemain.nta.nic.in</li>
                <li><strong>Coaching Institutes:</strong> FIITJEE, Allen, Resonance, Aakash, Bansal</li>
                <li><strong>Online Platforms:</strong> Embibe, Unacademy, Vedantu, BYJU\'S, Toppr</li>
                <li><strong>Previous Year Papers:</strong> Solve last 10 years papers as mock tests</li>
            </ul>
            
            <h4>How to Take Mock Tests Effectively</h4>
            <ul>
                <li>Take tests in exam-like conditions (quiet environment, no distractions)</li>
                <li>Stick to the actual exam duration strictly</li>
                <li>Don\'t check answers immediately after the test</li>
                <li>Analyze performance: identify topics needing more practice</li>
                <li>Review solutions for all questions, even correct ones</li>
                <li>Maintain a record of scores and track improvement</li>
                <li>Focus on weak areas identified in mock tests</li>
            </ul>
            
            <h4>Frequency</h4>
            <p>Take at least 2-3 mock tests per week in the final 3 months before the exam. Increase frequency to daily tests in the last month. For NATA, take tests for both drawing and aptitude sections separately as well as combined.</p>
            
            <h4>Mock Test Analysis</h4>
            <ul>
                <li>After each mock test, analyze your performance</li>
                <li>Identify which sections need more practice</li>
                <li>Note time taken for each section</li>
                <li>Review drawing submissions and get feedback</li>
                <li>Work on improving weak areas before the next test</li>
            </ul>
        ',
        'question_papers' => '
            <h4>Previous Year Question Papers</h4>
            <p>Solving previous year question papers is one of the most effective preparation strategies. It helps you understand:</p>
            <ul>
                <li>Exam pattern and difficulty level</li>
                <li>Important topics and frequently asked questions</li>
                <li>Time management requirements</li>
                <li>Your current preparation level</li>
                <li>Types of questions asked in drawing and aptitude sections</li>
            </ul>
            
            <h4>NATA Previous Year Papers</h4>
            <ul>
                <li><strong>Official Website:</strong> Download from nata.in</li>
                <li><strong>Coaching Institutes:</strong> Most institutes provide previous year papers</li>
                <li><strong>Books:</strong> Arihant, Disha, MTG publish NATA previous year papers</li>
                <li><strong>Online Platforms:</strong> Embibe, Unacademy, Vedantu offer free access</li>
            </ul>
            
            <h4>JEE Main Paper 2 Previous Year Papers</h4>
            <ul>
                <li><strong>Official Website:</strong> NTA website for JEE Main Paper 2 papers</li>
                <li><strong>Coaching Institutes:</strong> FIITJEE, Allen, Resonance provide compilation</li>
                <li><strong>Books:</strong> Arihant, Disha, MTG publish previous year papers</li>
                <li><strong>Online Platforms:</strong> Embibe, Unacademy, Vedantu offer free access</li>
            </ul>
            
            <h4>How to Use Question Papers</h4>
            <ul>
                <li>Start solving papers after completing syllabus</li>
                <li>Solve papers topic-wise first, then full-length papers</li>
                <li>Time yourself while solving to simulate exam conditions</li>
                <li>Analyze mistakes and revise weak topics</li>
                <li>Solve papers from last 5-10 years</li>
                <li>For drawing section, practice similar questions multiple times</li>
                <li>Get feedback on your drawings from teachers or mentors</li>
            </ul>
            
            <h4>Important Topics (Based on Previous Papers)</h4>
            <ul>
                <li><strong>Mathematics:</strong> Algebra, Calculus, Coordinate Geometry, Trigonometry</li>
                <li><strong>Aptitude:</strong> Visual reasoning, pattern recognition, architectural awareness, design principles</li>
                <li><strong>Drawing:</strong> Perspective drawing, 2D to 3D conversion, composition, architectural elements</li>
            </ul>
            
            <h4>Drawing Section Practice</h4>
            <ul>
                <li>Practice previous year drawing questions multiple times</li>
                <li>Focus on perspective, proportion, and composition</li>
                <li>Develop your own style while maintaining accuracy</li>
                <li>Time yourself - drawing questions have time limits</li>
                <li>Get your drawings evaluated by experienced architects or teachers</li>
            </ul>
        ',
        'study_material' => '
            <h4>Study Material for B.Arch Entrance Exams</h4>
            
            <h4>Recommended Books for NATA</h4>
            <ul>
                <li><strong>NATA & B.Arch Complete Self Study Material:</strong> by Ar. Shadan Usmani</li>
                <li><strong>NATA Entrance Exam Guide:</strong> by GKP</li>
                <li><strong>NATA & B.Arch Question Bank:</strong> by Ar. P. K. Mishra</li>
                <li><strong>NATA Drawing Test:</strong> by V. K. Jain</li>
                <li><strong>Architectural Awareness:</strong> Study books on famous buildings and architects</li>
            </ul>
            
            <h4>Recommended Books for JEE Main Paper 2</h4>
            <ul>
                <li><strong>Mathematics:</strong> RD Sharma, Cengage Series, Arihant</li>
                <li><strong>Aptitude:</strong> B.Arch Entrance Exam Guide by GKP, Arihant B.Arch Guide</li>
                <li><strong>Drawing:</strong> Perspective Drawing books, Architectural Drawing guides</li>
                <li><strong>Previous Year Papers:</strong> Arihant, Disha, MTG compilation books</li>
            </ul>
            
            <h4>Drawing Practice Resources</h4>
            <ul>
                <li><strong>Sketchbooks:</strong> Maintain daily sketchbook for practice</li>
                <li><strong>Drawing Tools:</strong> Pencils (HB, 2B, 4B), erasers, rulers, compass, set squares</li>
                <li><strong>Reference Books:</strong> Perspective Drawing by John Montague, Architectural Drawing by David Dernie</li>
                <li><strong>Online Tutorials:</strong> YouTube channels on architectural drawing and sketching</li>
            </ul>
            
            <h4>Online Resources</h4>
            <ul>
                <li><strong>Video Lectures:</strong> Unacademy, Vedantu, BYJU\'S, Embibe for NATA and JEE Main Paper 2</li>
                <li><strong>Practice Platforms:</strong> Embibe, Toppr, Meritnation offer practice questions</li>
                <li><strong>Mock Tests:</strong> Online platforms provide comprehensive mock test series</li>
                <li><strong>Doubt Solving:</strong> Online forums, Telegram groups, Discord communities</li>
                <li><strong>Architectural Awareness:</strong> Websites and apps showcasing famous buildings</li>
            </ul>
            
            <h4>Architectural Awareness Resources</h4>
            <ul>
                <li>Study famous architects: Le Corbusier, Frank Lloyd Wright, Zaha Hadid, etc.</li>
                <li>Learn about architectural styles: Modern, Post-modern, Contemporary, etc.</li>
                <li>Visit architectural websites: ArchDaily, Dezeen, Architectural Digest</li>
                <li>Watch documentaries on architecture and famous buildings</li>
                <li>Visit local buildings and analyze their design</li>
            </ul>
            
            <h4>Important Notes</h4>
            <ul>
                <li>Make chapter-wise notes while studying</li>
                <li>Create a formula sheet for mathematics</li>
                <li>Maintain a sketchbook with daily practice drawings</li>
                <li>Create flashcards for architectural awareness</li>
                <li>Revise notes and drawings regularly</li>
                <li>Join study groups for motivation and peer learning</li>
            </ul>
        ',
        'faqs' => '
            <h4>Frequently Asked Questions (FAQs)</h4>
            
            <div class="faq-item">
                <h4>Q1. What is the difference between B.Arch and B.Planning?</h4>
                <p><strong>A:</strong> B.Arch (Bachelor of Architecture) focuses on designing individual buildings and structures, emphasizing aesthetics, functionality, and construction. B.Planning (Bachelor of Planning) focuses on urban and regional planning, dealing with city planning, infrastructure, and development at a larger scale.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q2. Which entrance exam should I take for B.Arch - NATA or JEE Main Paper 2?</h4>
                <p><strong>A:</strong> NATA is accepted by most architecture colleges in India and is specifically designed for architecture aptitude. JEE Main Paper 2 is required for NITs, IIITs, and centrally funded institutes. Many students take both exams to maximize their college options. Check the admission criteria of your target colleges.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q3. What is a good NATA score for B.Arch admission?</h4>
                <p><strong>A:</strong> NATA score above 120 (out of 200): Top architecture colleges. Score 100-120: Good architecture colleges. Score 80-100: Decent architecture colleges. Score below 80: Many options available in private colleges. However, cutoff scores vary by college and year.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q4. Can I do B.Arch without Mathematics in 12th?</h4>
                <p><strong>A:</strong> No, Mathematics is mandatory for B.Arch admission. You must have Mathematics as a subject in 10+2 or in your 10+3 diploma. Some colleges may accept Mathematics as an additional subject, but it\'s best to check with individual colleges.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q5. What is the average salary after B.Arch?</h4>
                <p><strong>A:</strong> Average starting salary ranges from ₹3-6 LPA for most graduates. Top colleges (IITs, NITs, SPAs) see packages of ₹5-10 LPA. With experience and specialization, salaries can reach ₹15-30 LPA or higher in established firms or with your own practice.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q6. Is drawing skill mandatory for B.Arch?</h4>
                <p><strong>A:</strong> While natural drawing talent helps, it\'s not mandatory. Drawing skills can be developed with practice. The entrance exams test your aptitude for architecture, which includes observation, visualization, and creative thinking, not just drawing ability. Regular practice can significantly improve your drawing skills.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q7. What are the career options after B.Arch?</h4>
                <p><strong>A:</strong> After B.Arch, you can work as an Architect, Urban Planner, Landscape Architect, Interior Architect, Sustainable Architect, Heritage Conservation Architect, or start your own architectural firm. You can also pursue M.Arch for specialization or MBA for management roles in construction and real estate.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q8. Do I need to register with Council of Architecture (COA) after B.Arch?</h4>
                <p><strong>A:</strong> Yes, to practice as a professional architect in India, you must register with the Council of Architecture (COA) after completing B.Arch from a COA-approved institution. Registration is mandatory for legal practice and signing architectural drawings.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q9. Can I pursue B.Arch through distance learning?</h4>
                <p><strong>A:</strong> No, B.Arch is a professional course that requires regular attendance, studio work, site visits, and practical training. It cannot be pursued through distance learning. The Council of Architecture (COA) does not recognize distance learning B.Arch programs.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q10. What is the duration of B.Arch internship?</h4>
                <p><strong>A:</strong> B.Arch programs typically include a 6-8 weeks internship/training in architectural firms, usually in the 4th or 5th year. This provides practical exposure to real-world projects and helps students understand professional practice.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q11. Are there any age restrictions for B.Arch admission?</h4>
                <p><strong>A:</strong> Generally, there is no upper age limit for B.Arch admission. However, some institutions may have age restrictions, so it\'s best to check the specific eligibility criteria of your target colleges.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q12. What is the difference between B.Arch and B.E Civil Engineering?</h4>
                <p><strong>A:</strong> B.Arch focuses on design, aesthetics, spatial planning, and creating functional spaces. B.E Civil Engineering focuses on structural design, construction techniques, infrastructure, and technical aspects of building. Architects design buildings; Civil Engineers ensure they are structurally sound and can be built.</p>
            </div>
        ',
        'key_info' => [
            'Duration' => '5 Years (10 Semesters)',
            'Total Marks (NATA)' => '200 marks (Drawing: 125, Aptitude: 75)',
            'Total Marks (JEE Main Paper 2)' => '400 marks (Math: 100, Aptitude: 200, Drawing: 100)',
            'Exam Pattern (NATA)' => 'Drawing Test (125 marks) + Aesthetic Sensitivity Test (75 marks)',
            'Exam Pattern (JEE Main Paper 2)' => 'Mathematics (25 questions) + Aptitude (50 questions) + Drawing (2 questions)',
            'Languages' => 'English (NATA and JEE Main Paper 2)',
            'No. of Attempts (NATA)' => 'Multiple attempts allowed in a year',
            'No. of Attempts (JEE Main Paper 2)' => '3 attempts in consecutive years',
            'Application Fee (NATA)' => '₹2,000 (General), ₹1,500 (SC/ST/PWD)',
            'Application Fee (JEE Main Paper 2)' => '₹1,000 (General), ₹500 (SC/ST/PWD/Female)',
            'Official Website (NATA)' => 'nata.in',
            'Official Website (JEE Main Paper 2)' => 'jeemain.nta.nic.in',
            'Colleges Available' => '400+ architecture colleges in India',
            'Top Colleges' => 'IIT Kharagpur, IIT Roorkee, NIT Calicut, SPA Delhi, CEPT University',
            'Average Fees' => '₹1,00,000 - ₹3,50,000 per year',
            'Council Registration' => 'Mandatory registration with COA after graduation'
        ],
        'specializations' => [
            'Urban Planning & Design' => 'UP',
            'Landscape Architecture' => 'LA',
            'Interior Architecture' => 'IA',
            'Sustainable Architecture' => 'SA',
            'Building Information Modeling (BIM)' => 'BIM',
            'Heritage Conservation' => 'HC',
            'Industrial Architecture' => 'IND',
            'Residential Architecture' => 'RES',
            'Commercial Architecture' => 'COM',
            'Parametric Design' => 'PD'
        ],
        'updates' => [
            [
                'title' => 'NATA 2026 Registration Open - Apply Now for Architecture Entrance Exam',
                'date' => '2026-01-15',
                'author' => 'Eduspray Team',
                'content' => 'NATA 2026 registration is now open. Candidates can apply through the official NATA website. The exam will be conducted multiple times in 2026.'
            ],
            [
                'title' => 'JEE Main Paper 2 2026 Session 1 Exam Dates Announced',
                'date' => '2026-01-12',
                'author' => 'Eduspray Team',
                'content' => 'JEE Main Paper 2 Session 1 exam will be conducted from January 20-29, 2026. Results expected by February 11, 2026.'
            ],
            [
                'title' => 'New Architecture Colleges Added - 50+ B.Arch Programs Now Available',
                'date' => '2026-01-10',
                'author' => 'Eduspray Team',
                'content' => 'We have added 50+ new architecture colleges to our database. Check out the latest B.Arch admission options for 2026.'
            ],
            [
                'title' => 'B.Arch Admission Process 2026 - Complete Guide Released',
                'date' => '2026-01-08',
                'author' => 'Eduspray Team',
                'content' => 'Complete guide to B.Arch admission process, important dates, eligibility criteria, and counseling procedures for 2026 academic year.'
            ],
            [
                'title' => 'Top Architecture Colleges Accepting NATA 2026 Scores',
                'date' => '2026-01-05',
                'author' => 'Eduspray Team',
                'content' => 'List of top architecture colleges accepting NATA scores for B.Arch admission. Includes IITs, NITs, SPAs, and private architecture colleges.'
            ]
        ]
    ],
    
    'bhmct' => [
        'name' => 'BHMCT',
        'full_name' => 'Bachelor of Hotel Management & Catering Technology',
        'icon' => 'fas fa-hotel',
        'duration' => '4 Years',
        'avg_fees' => '₹50,000 - ₹3,00,000 per year',
        'short_description' => 'BHMCT is a 4-year undergraduate program that prepares students for careers in hospitality, hotel management, and catering technology.',
        'description' => '
            <p>Bachelor of Hotel Management & Catering Technology (BHMCT) is a 4-year professional degree program designed to equip students with the necessary skills and knowledge for the hospitality and tourism industry. The program combines theoretical knowledge with practical training in hotel operations, food production, and service management.</p>
            
            <h4>Why Choose BHMCT?</h4>
            <ul>
                <li><strong>Growing Industry:</strong> Hospitality and tourism sector is one of the fastest-growing industries globally</li>
                <li><strong>Diverse Career Opportunities:</strong> Hotels, resorts, cruise lines, airlines, event management, and more</li>
                <li><strong>Global Exposure:</strong> Work opportunities in international hotels and resorts</li>
                <li><strong>Practical Training:</strong> Hands-on experience through internships and industry exposure</li>
                <li><strong>Entrepreneurship:</strong> Start your own restaurant, catering business, or event management company</li>
                <li><strong>High Demand:</strong> Constant demand for skilled hospitality professionals</li>
            </ul>
            
            <h4>Skills Developed</h4>
            <div class="specializations-grid">
                <span class="spec-tag">Customer Service</span>
                <span class="spec-tag">Food Production</span>
                <span class="spec-tag">Event Management</span>
                <span class="spec-tag">Communication</span>
                <span class="spec-tag">Leadership</span>
                <span class="spec-tag">Financial Management</span>
                <span class="spec-tag">Marketing</span>
                <span class="spec-tag">Operations Management</span>
            </div>
            
            <h4>Program Structure</h4>
            <p>The BHMCT program is divided into 8 semesters over 4 years, including:</p>
            <ul>
                <li>Core hospitality management courses</li>
                <li>Food production and culinary arts</li>
                <li>Food and beverage service</li>
                <li>Front office operations</li>
                <li>Housekeeping management</li>
                <li>Hotel accounting and finance</li>
                <li>Marketing and sales</li>
                <li>Industrial training and internships</li>
            </ul>
        ',
        'eligibility' => '
            <h4>Academic Requirements</h4>
            <ul>
                <li><strong>10+2 Qualification:</strong> Passed 10+2 or equivalent examination from a recognized board</li>
                <li><strong>Minimum Marks:</strong> 45-50% aggregate marks (varies by institution and category)</li>
                <li><strong>Stream:</strong> Any stream (Science, Commerce, or Arts)</li>
                <li><strong>Age Limit:</strong> Generally 17-25 years (varies by institution)</li>
                <li><strong>English Proficiency:</strong> Good command over English language</li>
            </ul>
            
            <h4>Entrance Exams</h4>
            <p>Admission to BHMCT programs requires valid scores in one of the following entrance exams:</p>
            <ul>
                <li><strong>NCHMCT JEE (National Council for Hotel Management Joint Entrance Examination):</strong>
                    <ul>
                        <li>Conducted by National Testing Agency (NTA)</li>
                        <li>For admission to IHMs (Institute of Hotel Management) and affiliated colleges</li>
                        <li>Tests aptitude in English, reasoning, numerical ability, and general knowledge</li>
                        <li>Official website: nchmjee.nta.nic.in</li>
                    </ul>
                </li>
                <li><strong>State-Level Exams:</strong>
                    <ul>
                        <li><strong>MAH-B.HMCT-CET:</strong> Maharashtra State Common Entrance Test</li>
                        <li><strong>IPU CET:</strong> For Delhi-based colleges (GGSIPU)</li>
                        <li><strong>UPSEE:</strong> Uttar Pradesh State Entrance Examination</li>
                        <li><strong>WBJEE:</strong> West Bengal Joint Entrance Examination</li>
                    </ul>
                </li>
                <li><strong>University-Specific Exams:</strong>
                    <ul>
                        <li>Christ University Entrance Test</li>
                        <li>Symbiosis SET</li>
                        <li>Manipal University Entrance Test</li>
                    </ul>
                </li>
            </ul>
        ',
        'career_options' => '
            <h4>Top Career Paths</h4>
            <div class="career-grid">
                <div class="career-card">
                    <i class="fas fa-hotel"></i>
                    <h5>Hotel Manager</h5>
                    <p>₹6-25 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-utensils"></i>
                    <h5>Executive Chef</h5>
                    <p>₹8-30 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-concierge-bell"></i>
                    <h5>Front Office Manager</h5>
                    <p>₹5-18 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-bed"></i>
                    <h5>Housekeeping Manager</h5>
                    <p>₹4-15 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-plane"></i>
                    <h5>Airline Cabin Crew</h5>
                    <p>₹5-15 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-ship"></i>
                    <h5>Cruise Ship Manager</h5>
                    <p>₹8-35 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-calendar-alt"></i>
                    <h5>Event Manager</h5>
                    <p>₹4-20 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-chart-line"></i>
                    <h5>Revenue Manager</h5>
                    <p>₹6-20 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-bullhorn"></i>
                    <h5>Sales & Marketing Manager</h5>
                    <p>₹5-18 LPA</p>
                </div>
            </div>
            
            <h4>Top Recruiters</h4>
            <p>Taj Hotels, Oberoi Hotels, ITC Hotels, Marriott International, Hyatt Hotels, Hilton Hotels, Radisson Hotels, Leela Hotels, ITDC, Indian Railways Catering, Airlines (IndiGo, SpiceJet, Air India), Cruise Lines, and leading event management companies.</p>
            
            <h4>Higher Studies Options</h4>
            <ul>
                <li><strong>MHM (Master of Hotel Management):</strong> Advanced specialization in hotel management</li>
                <li><strong>MBA in Hospitality Management:</strong> For management roles in hospitality industry</li>
                <li><strong>MBA in Tourism Management:</strong> For careers in tourism and travel</li>
                <li><strong>International Programs:</strong> Master\'s programs from top hospitality schools abroad (Switzerland, USA, UK)</li>
            </ul>
            
            <h4>Entrepreneurship</h4>
            <p>Many BHMCT graduates start their own businesses including restaurants, catering services, event management companies, travel agencies, or boutique hotels. The practical training and industry exposure during the course provide excellent foundation for entrepreneurship.</p>
        ',
        'syllabus' => '
            <h4>BHMCT Syllabus Overview</h4>
            <p>The BHMCT curriculum is divided into 8 semesters over 4 years, covering all aspects of hotel management, food production, and hospitality services.</p>
            
            <h4>First Year (Semesters 1-2)</h4>
            <ul>
                <li><strong>Food Production Foundation:</strong> Basic cooking techniques, kitchen operations, food safety</li>
                <li><strong>Food & Beverage Service:</strong> Table service, bar operations, menu planning</li>
                <li><strong>Front Office Operations:</strong> Reservation systems, guest relations, check-in/check-out</li>
                <li><strong>Housekeeping Operations:</strong> Room cleaning, laundry, maintenance</li>
                <li><strong>Communication Skills:</strong> English, business communication, soft skills</li>
                <li><strong>Hotel Accounting:</strong> Basic accounting principles, financial statements</li>
                <li><strong>Computer Applications:</strong> Hotel management software, MS Office</li>
            </ul>
            
            <h4>Second Year (Semesters 3-4)</h4>
            <ul>
                <li><strong>Advanced Food Production:</strong> Continental, Indian, Chinese cuisines</li>
                <li><strong>Beverage Management:</strong> Wine, spirits, bar management</li>
                <li><strong>Front Office Management:</strong> Revenue management, yield management</li>
                <li><strong>Housekeeping Management:</strong> Staff management, inventory control</li>
                <li><strong>Hotel Law:</strong> Legal aspects of hospitality industry</li>
                <li><strong>Marketing Management:</strong> Hotel marketing, sales techniques</li>
                <li><strong>Human Resource Management:</strong> Staff recruitment, training, development</li>
            </ul>
            
            <h4>Third Year (Semesters 5-6)</h4>
            <ul>
                <li><strong>Specialized Cuisines:</strong> Bakery, confectionery, international cuisines</li>
                <li><strong>Food & Beverage Management:</strong> Cost control, menu engineering</li>
                <li><strong>Hotel Operations Management:</strong> Overall hotel operations</li>
                <li><strong>Financial Management:</strong> Budgeting, cost analysis, financial planning</li>
                <li><strong>Tourism Management:</strong> Travel and tourism operations</li>
                <li><strong>Event Management:</strong> Planning and organizing events</li>
                <li><strong>Industrial Training:</strong> 6-month internship in hotels/restaurants</li>
            </ul>
            
            <h4>Fourth Year (Semesters 7-8)</h4>
            <ul>
                <li><strong>Strategic Management:</strong> Business strategy, competitive analysis</li>
                <li><strong>Hotel Project Management:</strong> Hotel development, renovation</li>
                <li><strong>Research Methodology:</strong> Research in hospitality industry</li>
                <li><strong>Entrepreneurship:</strong> Starting and managing hospitality businesses</li>
                <li><strong>Specialization Electives:</strong> Choose from various specializations</li>
                <li><strong>Dissertation/Project:</strong> Research project on hospitality topic</li>
            </ul>
            
            <h4>Practical Components</h4>
            <ul>
                <li>Kitchen training and food production labs</li>
                <li>Service training in restaurants and bars</li>
                <li>Front office and housekeeping practical sessions</li>
                <li>Industrial training/internship (typically 6 months)</li>
                <li>Site visits to hotels, resorts, and hospitality establishments</li>
                <li>Event management projects</li>
            </ul>
        ',
        'preparation_tips' => '
            <h4>How to Prepare for BHMCT Entrance Exams</h4>
            
            <h4>1. Understanding NCHMCT JEE</h4>
            <p>NCHMCT JEE (now conducted by NTA) tests your aptitude in:</p>
            <ul>
                <li><strong>English Language:</strong> Grammar, vocabulary, comprehension</li>
                <li><strong>Numerical Ability:</strong> Basic mathematics, calculations</li>
                <li><strong>Reasoning:</strong> Logical reasoning, analytical ability</li>
                <li><strong>General Knowledge:</strong> Current affairs, general awareness</li>
                <li><strong>Aptitude for Service Sector:</strong> Customer service orientation</li>
            </ul>
            
            <h4>2. NCHMCT JEE Preparation Strategy</h4>
            <ul>
                <li><strong>English:</strong> Improve vocabulary, practice reading comprehension, grammar exercises</li>
                <li><strong>Mathematics:</strong> Focus on basic arithmetic, percentages, ratios, profit & loss</li>
                <li><strong>Reasoning:</strong> Practice logical reasoning, puzzles, data interpretation</li>
                <li><strong>General Knowledge:</strong> Stay updated with current affairs, read newspapers daily</li>
                <li><strong>Mock Tests:</strong> Take regular mock tests to understand exam pattern</li>
                <li><strong>Time Management:</strong> Practice solving questions within time limits</li>
            </ul>
            
            <h4>3. State-Level Exam Preparation</h4>
            <ul>
                <li>Understand the specific exam pattern for your state</li>
                <li>Focus on state-specific general knowledge</li>
                <li>Practice previous year question papers</li>
                <li>Join coaching classes if needed</li>
            </ul>
            
            <h4>4. Important Preparation Tips</h4>
            <ul>
                <li>Start preparation at least 3-6 months before the exam</li>
                <li>Create a study schedule and stick to it</li>
                <li>Focus on weak areas identified in mock tests</li>
                <li>Read English newspapers daily to improve language skills</li>
                <li>Practice mental math for faster calculations</li>
                <li>Stay updated with current affairs and hospitality industry news</li>
                <li>Take regular breaks to avoid burnout</li>
            </ul>
            
            <h4>5. Recommended Study Schedule</h4>
            <ul>
                <li><strong>Morning (2-3 hours):</strong> English and General Knowledge</li>
                <li><strong>Afternoon (2-3 hours):</strong> Mathematics and Reasoning</li>
                <li><strong>Evening (1-2 hours):</strong> Revision and practice</li>
                <li><strong>Weekly:</strong> Take one full-length mock test</li>
                <li><strong>Monthly:</strong> Review progress and adjust strategy</li>
            </ul>
        ',
        'mock_tests' => '
            <h4>Mock Test Series for BHMCT Entrance Exams</h4>
            <p>Regular practice with mock tests is essential for success in NCHMCT JEE and other entrance exams. Here\'s how to make the most of them:</p>
            
            <h4>Benefits of Mock Tests</h4>
            <ul>
                <li>Familiarize yourself with exam pattern and timing</li>
                <li>Identify strengths and weaknesses in different sections</li>
                <li>Improve time management skills</li>
                <li>Build exam-day confidence</li>
                <li>Track your progress over time</li>
            </ul>
            
            <h4>NCHMCT JEE Mock Tests</h4>
            <ul>
                <li><strong>Official NTA Mock Tests:</strong> Available on nchmjee.nta.nic.in</li>
                <li><strong>Coaching Institutes:</strong> IHM coaching centers, private coaching institutes</li>
                <li><strong>Online Platforms:</strong> Embibe, Unacademy, Vedantu, BYJU\'S, Gradeup</li>
                <li><strong>Previous Year Papers:</strong> Solve last 5-10 years papers as mock tests</li>
            </ul>
            
            <h4>How to Take Mock Tests Effectively</h4>
            <ul>
                <li>Take tests in exam-like conditions</li>
                <li>Stick to the actual exam duration</li>
                <li>Don\'t check answers immediately after the test</li>
                <li>Analyze performance: identify topics needing more practice</li>
                <li>Review solutions for all questions</li>
                <li>Maintain a record of scores and track improvement</li>
            </ul>
            
            <h4>Frequency</h4>
            <p>Take at least 2-3 mock tests per week in the final 2-3 months before the exam. Increase frequency to daily tests in the last month.</p>
        ',
        'question_papers' => '
            <h4>Previous Year Question Papers</h4>
            <p>Solving previous year question papers helps you understand exam pattern, important topics, and time management requirements.</p>
            
            <h4>Where to Find Question Papers</h4>
            <ul>
                <li><strong>Official Website:</strong> NTA website for NCHMCT JEE papers</li>
                <li><strong>Coaching Institutes:</strong> Most institutes provide previous year papers</li>
                <li><strong>Books:</strong> Arihant, Disha, MTG publish compilation books</li>
                <li><strong>Online Platforms:</strong> Embibe, Unacademy, Vedantu offer free access</li>
            </ul>
            
            <h4>How to Use Question Papers</h4>
            <ul>
                <li>Start solving papers after completing syllabus</li>
                <li>Time yourself while solving</li>
                <li>Analyze mistakes and revise weak topics</li>
                <li>Solve papers from last 5-10 years</li>
            </ul>
        ',
        'study_material' => '
            <h4>Study Material for BHMCT Entrance Exams</h4>
            
            <h4>Recommended Books</h4>
            <ul>
                <li><strong>NCHMCT JEE Guide:</strong> By Arihant, Disha, or GKP</li>
                <li><strong>English:</strong> Wren & Martin, Objective English by SP Bakshi</li>
                <li><strong>Mathematics:</strong> Quantitative Aptitude by RS Aggarwal</li>
                <li><strong>Reasoning:</strong> A Modern Approach to Verbal & Non-Verbal Reasoning by RS Aggarwal</li>
                <li><strong>General Knowledge:</strong> Lucent\'s General Knowledge, Manorama Yearbook</li>
            </ul>
            
            <h4>Online Resources</h4>
            <ul>
                <li><strong>Video Lectures:</strong> Unacademy, Vedantu, BYJU\'S for NCHMCT JEE preparation</li>
                <li><strong>Practice Platforms:</strong> Embibe, Toppr, Meritnation</li>
                <li><strong>Current Affairs:</strong> Read newspapers, follow news apps</li>
            </ul>
        ',
        'faqs' => '
            <h4>Frequently Asked Questions (FAQs)</h4>
            
            <div class="faq-item">
                <h4>Q1. What is the difference between BHMCT and BHM?</h4>
                <p><strong>A:</strong> BHMCT (Bachelor of Hotel Management & Catering Technology) and BHM (Bachelor of Hotel Management) are essentially the same course with slightly different names. Both are 4-year programs focusing on hotel management and hospitality operations.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q2. Which entrance exam should I take for BHMCT?</h4>
                <p><strong>A:</strong> NCHMCT JEE is the most common exam for admission to IHMs and affiliated colleges. However, many states conduct their own entrance exams, and some private universities have their own admission tests. Check the admission criteria of your target colleges.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q3. What is a good NCHMCT JEE rank for BHMCT admission?</h4>
                <p><strong>A:</strong> Rank below 500: Top IHMs. Rank 500-2000: Good IHMs and reputed colleges. Rank 2000-5000: Decent hotel management colleges. Rank above 5000: Many options available in private colleges.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q4. Is BHMCT a good career option?</h4>
                <p><strong>A:</strong> Yes, BHMCT offers excellent career opportunities in the growing hospitality and tourism industry. With global exposure, diverse career paths, and good earning potential, it\'s a rewarding career choice for those interested in service-oriented professions.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q5. What is the average salary after BHMCT?</h4>
                <p><strong>A:</strong> Average starting salary ranges from ₹3-6 LPA for most graduates. Top colleges (IHMs) see packages of ₹5-10 LPA. With experience and specialization, salaries can reach ₹15-30 LPA or higher in senior management roles or international positions.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q6. Can I work abroad after BHMCT?</h4>
                <p><strong>A:</strong> Yes, BHMCT graduates have excellent opportunities to work abroad in international hotel chains, cruise lines, and hospitality companies. Many top hotel chains recruit from Indian hotel management institutes for their global operations.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q7. What are the career options after BHMCT?</h4>
                <p><strong>A:</strong> After BHMCT, you can work as Hotel Manager, Chef, Front Office Manager, Housekeeping Manager, Event Manager, Airline Cabin Crew, Cruise Ship Manager, or start your own hospitality business.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q8. Is internship mandatory in BHMCT?</h4>
                <p><strong>A:</strong> Yes, most BHMCT programs include a mandatory 6-month industrial training/internship in hotels, restaurants, or hospitality establishments. This provides practical exposure and often leads to job offers.</p>
            </div>
        ',
        'key_info' => [
            'Duration' => '4 Years (8 Semesters)',
            'Total Marks (NCHMCT JEE)' => '200 marks',
            'Exam Pattern (NCHMCT JEE)' => 'English (30), Numerical Ability (30), Reasoning (30), General Knowledge (30), Aptitude for Service Sector (80)',
            'Languages' => 'English',
            'No. of Attempts' => 'Unlimited (varies by exam)',
            'Application Fee (NCHMCT JEE)' => '₹1,000 (General), ₹500 (SC/ST/PWD)',
            'Official Website (NCHMCT JEE)' => 'nchmjee.nta.nic.in',
            'Colleges Available' => '100+ hotel management colleges in India',
            'Top Colleges' => 'IHM Mumbai, IHM Delhi, IHM Bangalore, IHM Hyderabad, IHM Kolkata',
            'Average Fees' => '₹50,000 - ₹3,00,000 per year',
            'Internship Duration' => '6 months (mandatory)',
            'Approval' => 'AICTE approved'
        ],
        'specializations' => [
            'Culinary Arts' => 'CA',
            'Food & Beverage Management' => 'FBM',
            'Front Office Management' => 'FOM',
            'Housekeeping Management' => 'HKM',
            'Event Management' => 'EM',
            'Tourism Management' => 'TM',
            'Revenue Management' => 'RM',
            'Sales & Marketing' => 'SM'
        ],
        'updates' => [
            [
                'title' => 'NCHMCT JEE 2026 Registration Open - Apply Now for Hotel Management Admission',
                'date' => '2026-01-15',
                'author' => 'Eduspray Team',
                'content' => 'NCHMCT JEE 2026 registration is now open. Candidates can apply through the official NTA website for admission to IHMs and affiliated colleges.'
            ],
            [
                'title' => 'BHMCT Admission 2026 - Complete Guide Released',
                'date' => '2026-01-12',
                'author' => 'Eduspray Team',
                'content' => 'Complete guide to BHMCT admission process, important dates, eligibility criteria, and counseling procedures for 2026 academic year.'
            ],
            [
                'title' => 'New Hotel Management Colleges Added - 30+ BHMCT Programs Now Available',
                'date' => '2026-01-10',
                'author' => 'Eduspray Team',
                'content' => 'We have added 30+ new hotel management colleges to our database. Check out the latest BHMCT admission options for 2026.'
            ]
        ]
    ],
    
    'hotel' => [
        'name' => 'Hotel Management',
        'full_name' => 'Bachelor of Hotel Management & Catering Technology',
        'icon' => 'fas fa-concierge-bell',
        'duration' => '3-4 Years',
        'avg_fees' => '₹50,000 - ₹3,00,000 per year',
        'short_description' => 'Hotel Management courses prepare students for careers in hospitality, hotels, and food service industry.',
        'description' => '
            <p>Hotel Management is a dynamic field that combines business skills with hospitality expertise. Students learn hotel operations, food & beverage management, housekeeping, and customer service.</p>
            
            <h4>Why Choose Hotel Management?</h4>
            <ul>
                <li><strong>Growing Industry:</strong> Tourism and hospitality booming in India</li>
                <li><strong>Global Opportunities:</strong> Work in hotels worldwide</li>
                <li><strong>Diverse Careers:</strong> Hotels, restaurants, cruise ships, airlines</li>
                <li><strong>Early Employment:</strong> Industrial training leads to job offers</li>
            </ul>
        ',
        'eligibility' => '
            <h4>Academic Requirements</h4>
            <ul>
                <li>10+2 from any stream</li>
                <li>Minimum 50% aggregate marks</li>
                <li>Good communication skills</li>
            </ul>
            
            <h4>Entrance Exams</h4>
            <ul>
                <li><strong>NCHMCT JEE:</strong> For IHMs and central institutes</li>
                <li><strong>IPU CET:</strong> For Delhi-based colleges</li>
            </ul>
        ',
        'career_options' => '
            <h4>Top Career Paths</h4>
            <div class="career-grid">
                <div class="career-card">
                    <i class="fas fa-hotel"></i>
                    <h5>Hotel Manager</h5>
                    <p>₹6-25 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-utensils"></i>
                    <h5>Chef</h5>
                    <p>₹4-20 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-plane"></i>
                    <h5>Airline Crew</h5>
                    <p>₹5-15 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-ship"></i>
                    <h5>Cruise Manager</h5>
                    <p>₹8-30 LPA</p>
                </div>
            </div>
            
            <h4>Top Recruiters</h4>
            <p>Taj Hotels, Oberoi Hotels, ITC Hotels, Marriott International, Hyatt Hotels, Hilton Hotels, and leading hospitality chains.</p>
            
            <h4>Higher Studies Options</h4>
            <ul>
                <li><strong>MHM (Master of Hotel Management):</strong> Advanced specialization</li>
                <li><strong>MBA in Hospitality:</strong> For management roles</li>
                <li><strong>International Programs:</strong> Master\'s from top hospitality schools abroad</li>
            </ul>
        ',
        'syllabus' => '
            <h4>Hotel Management Syllabus Overview</h4>
            <p>The Hotel Management curriculum covers hotel operations, food production, service management, and hospitality operations.</p>
            
            <h4>Core Subjects</h4>
            <ul>
                <li>Food Production and Culinary Arts</li>
                <li>Food & Beverage Service</li>
                <li>Front Office Operations</li>
                <li>Housekeeping Management</li>
                <li>Hotel Accounting and Finance</li>
                <li>Marketing and Sales</li>
                <li>Human Resource Management</li>
                <li>Tourism Management</li>
            </ul>
        ',
        'preparation_tips' => '
            <h4>How to Prepare for Hotel Management Entrance Exams</h4>
            <p>Focus on English, Mathematics, General Knowledge, and Logical Reasoning. Practice mock tests regularly and stay updated with hospitality industry news.</p>
        ',
        'mock_tests' => '
            <h4>Mock Test Series</h4>
            <p>Take regular mock tests from official websites, coaching institutes, and online platforms like Embibe, Unacademy, Vedantu.</p>
        ',
        'question_papers' => '
            <h4>Previous Year Question Papers</h4>
            <p>Solve previous year papers from official websites and coaching institutes to understand exam pattern.</p>
        ',
        'study_material' => '
            <h4>Study Material</h4>
            <p>Recommended books: NCHMCT JEE Guide, RS Aggarwal for Mathematics, Wren & Martin for English, and Lucent\'s GK for General Knowledge.</p>
        ',
        'faqs' => '
            <h4>Frequently Asked Questions (FAQs)</h4>
            
            <div class="faq-item">
                <h4>Q1. What is the difference between Hotel Management and BHMCT?</h4>
                <p><strong>A:</strong> Hotel Management and BHMCT are essentially the same course with different names. Both prepare students for careers in hospitality and hotel operations.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q2. What is the average salary after Hotel Management?</h4>
                <p><strong>A:</strong> Average starting salary ranges from ₹3-6 LPA. With experience, salaries can reach ₹15-30 LPA or higher in senior management roles.</p>
            </div>
        ',
        'key_info' => [
            'Duration' => '3-4 Years',
            'Total Marks' => 'Varies by Exam',
            'Exam Pattern' => 'Entrance Exam Based',
            'Languages' => 'English',
            'Colleges Available' => '100+ hotel management colleges',
            'Top Colleges' => 'IHM Mumbai, IHM Delhi, IHM Bangalore',
            'Average Fees' => '₹50,000 - ₹3,00,000 per year'
        ],
        'specializations' => [
            'Culinary Arts' => 'CA',
            'Food & Beverage' => 'F&B',
            'Front Office' => 'FO',
            'Housekeeping' => 'HK',
            'Event Management' => 'EM'
        ],
        'updates' => [
            [
                'title' => 'Hotel Management Admission 2026 - Applications Open',
                'date' => '2026-01-15',
                'author' => 'Eduspray Team',
                'content' => 'Hotel Management admission applications are now open for 2026. Check out top colleges and admission procedures.'
            ]
        ]
    ],
    
    'journalism' => [
        'name' => 'Journalism',
        'full_name' => 'Bachelor of Arts in Journalism & Mass Communication',
        'icon' => 'fas fa-bullhorn',
        'duration' => '3 Years',
        'avg_fees' => '₹30,000 - ₹2,00,000 per year',
        'short_description' => 'Journalism courses prepare students for careers in media, broadcasting, digital content, and communications.',
        'description' => '
            <p>Journalism and Mass Communication is a vibrant field that combines storytelling with media technologies. Students learn news reporting, broadcasting, digital media, advertising, and public relations.</p>
            
            <h4>Why Choose Journalism?</h4>
            <ul>
                <li><strong>Voice of Society:</strong> Be the watchdog of democracy</li>
                <li><strong>Creative Expression:</strong> Tell stories that matter</li>
                <li><strong>Digital Revolution:</strong> New media creating opportunities</li>
                <li><strong>Diverse Roles:</strong> Reporter, anchor, editor, content creator</li>
            </ul>
        ',
        'eligibility' => '
            <h4>Academic Requirements</h4>
            <ul>
                <li>10+2 from any stream</li>
                <li>Minimum 50% aggregate marks</li>
                <li>Excellent communication skills</li>
            </ul>
            
            <h4>Entrance Exams</h4>
            <ul>
                <li><strong>IPU CET BJMC:</strong> For Delhi colleges</li>
                <li><strong>CUET:</strong> Common University Entrance Test</li>
                <li><strong>XIC OET:</strong> Xavier Institute of Communications</li>
            </ul>
        ',
        'career_options' => '
            <h4>Top Career Paths</h4>
            <div class="career-grid">
                <div class="career-card">
                    <i class="fas fa-newspaper"></i>
                    <h5>Journalist</h5>
                    <p>₹4-15 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-tv"></i>
                    <h5>News Anchor</h5>
                    <p>₹5-50 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-video"></i>
                    <h5>Video Editor</h5>
                    <p>₹3-12 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-hashtag"></i>
                    <h5>Social Media Manager</h5>
                    <p>₹4-15 LPA</p>
                </div>
            </div>
            
            <h4>Top Recruiters</h4>
            <p>Times of India, Hindustan Times, NDTV, CNN-IBN, BBC, Zee News, India Today, The Hindu, and leading media houses.</p>
            
            <h4>Higher Studies Options</h4>
            <ul>
                <li><strong>MA in Journalism:</strong> Advanced specialization in journalism</li>
                <li><strong>MA in Mass Communication:</strong> For media and communication careers</li>
                <li><strong>MBA:</strong> For management roles in media industry</li>
            </ul>
        ',
        'syllabus' => '
            <h4>Journalism & Mass Communication Syllabus Overview</h4>
            <p>The curriculum covers news reporting, broadcasting, digital media, advertising, and public relations over 6 semesters.</p>
            
            <h4>Core Subjects</h4>
            <ul>
                <li>News Writing and Reporting</li>
                <li>Broadcast Journalism</li>
                <li>Digital Media and Social Media</li>
                <li>Advertising and Public Relations</li>
                <li>Media Laws and Ethics</li>
                <li>Photojournalism</li>
                <li>Video Production</li>
                <li>Media Research</li>
            </ul>
        ',
        'preparation_tips' => '
            <h4>How to Prepare for Journalism Entrance Exams</h4>
            <p>Focus on English, General Knowledge, Current Affairs, and Communication Skills. Stay updated with news and practice writing.</p>
        ',
        'mock_tests' => '
            <h4>Mock Test Series</h4>
            <p>Take regular mock tests from official websites and online platforms.</p>
        ',
        'question_papers' => '
            <h4>Previous Year Question Papers</h4>
            <p>Solve previous year papers to understand exam pattern.</p>
        ',
        'study_material' => '
            <h4>Study Material</h4>
            <p>Read newspapers daily, follow news channels, and practice writing. Recommended books on journalism and mass communication.</p>
        ',
        'faqs' => '
            <h4>Frequently Asked Questions (FAQs)</h4>
            
            <div class="faq-item">
                <h4>Q1. What is the average salary after Journalism?</h4>
                <p><strong>A:</strong> Average starting salary ranges from ₹3-6 LPA. With experience, salaries can reach ₹10-30 LPA or higher in senior roles.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q2. Is Journalism a good career option?</h4>
                <p><strong>A:</strong> Yes, journalism offers diverse career opportunities in print, broadcast, and digital media with good growth prospects.</p>
            </div>
        ',
        'key_info' => [
            'Duration' => '3 Years (6 Semesters)',
            'Total Marks' => 'Varies by University',
            'Exam Pattern' => 'Entrance Exam Based',
            'Languages' => 'English',
            'Colleges Available' => '200+ journalism colleges',
            'Top Colleges' => 'DU, IPU, Symbiosis, XIC',
            'Average Fees' => '₹30,000 - ₹2,00,000 per year'
        ],
        'specializations' => [
            'Print Journalism' => 'PJ',
            'Broadcast Journalism' => 'BJ',
            'Digital Media' => 'DM',
            'Advertising' => 'ADV',
            'Public Relations' => 'PR'
        ],
        'updates' => [
            [
                'title' => 'Journalism Admission 2026 - Applications Open',
                'date' => '2026-01-15',
                'author' => 'Eduspray Team',
                'content' => 'Journalism admission applications are now open for 2026. Check out top colleges and admission procedures.'
            ]
        ]
    ],
    
    'commerce' => [
        'name' => 'Commerce',
        'full_name' => 'Bachelor of Commerce',
        'icon' => 'fas fa-calculator',
        'duration' => '3 Years',
        'avg_fees' => '₹20,000 - ₹1,50,000 per year',
        'short_description' => 'B.Com provides foundational knowledge in commerce, accounting, finance, and business studies.',
        'description' => '
            <p>Bachelor of Commerce (B.Com) is one of the most popular undergraduate programs in India. It provides comprehensive knowledge of accounting, finance, taxation, and business operations.</p>
            
            <h4>Why Choose B.Com?</h4>
            <ul>
                <li><strong>Foundation for CA/CS:</strong> Ideal base for professional courses</li>
                <li><strong>Affordable:</strong> Lower fees compared to professional courses</li>
                <li><strong>Job-Ready:</strong> Direct employment in finance sector</li>
                <li><strong>Versatile:</strong> Multiple specialization options</li>
            </ul>
        ',
        'eligibility' => '
            <h4>Academic Requirements</h4>
            <ul>
                <li>10+2 with Commerce stream (preferred)</li>
                <li>Minimum 50% aggregate marks</li>
                <li>Science/Arts students also eligible</li>
            </ul>
        ',
        'career_options' => '
            <h4>Top Career Paths</h4>
            <div class="career-grid">
                <div class="career-card">
                    <i class="fas fa-calculator"></i>
                    <h5>Accountant</h5>
                    <p>₹3-10 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <h5>Tax Consultant</h5>
                    <p>₹4-15 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-university"></i>
                    <h5>Bank PO</h5>
                    <p>₹5-12 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-chart-pie"></i>
                    <h5>Financial Analyst</h5>
                    <p>₹5-20 LPA</p>
                </div>
            </div>
            
            <h4>Top Recruiters</h4>
            <p>Banks (SBI, HDFC, ICICI), accounting firms (Deloitte, KPMG, EY, PwC), insurance companies, and financial institutions.</p>
            
            <h4>Higher Studies Options</h4>
            <ul>
                <li><strong>M.Com:</strong> Master of Commerce</li>
                <li><strong>MBA:</strong> For management roles</li>
                <li><strong>Professional Courses:</strong> CA, CS, CMA</li>
            </ul>
        ',
        'syllabus' => '
            <h4>B.Com Syllabus Overview</h4>
            <p>The B.Com curriculum covers accounting, finance, taxation, and business operations over 6 semesters.</p>
            
            <h4>Core Subjects</h4>
            <ul>
                <li>Financial Accounting</li>
                <li>Cost Accounting</li>
                <li>Business Law</li>
                <li>Economics</li>
                <li>Business Mathematics</li>
                <li>Taxation</li>
                <li>Auditing</li>
                <li>Business Management</li>
            </ul>
        ',
        'preparation_tips' => '
            <h4>How to Prepare for B.Com Entrance Exams</h4>
            <p>Focus on Mathematics, English, and General Knowledge. Most colleges admit based on 12th marks, but some conduct entrance exams.</p>
        ',
        'mock_tests' => '
            <h4>Mock Test Series</h4>
            <p>Take regular mock tests if your target college conducts entrance exams.</p>
        ',
        'question_papers' => '
            <h4>Previous Year Question Papers</h4>
            <p>Solve previous year papers if available for your target college.</p>
        ',
        'study_material' => '
            <h4>Study Material</h4>
            <p>Focus on 12th Commerce subjects. Recommended books on accounting and business studies.</p>
        ',
        'faqs' => '
            <h4>Frequently Asked Questions (FAQs)</h4>
            
            <div class="faq-item">
                <h4>Q1. What is the difference between B.Com and BBA?</h4>
                <p><strong>A:</strong> B.Com focuses on commerce, accounting, and finance, while BBA focuses on business administration and management.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q2. Can I do CA after B.Com?</h4>
                <p><strong>A:</strong> Yes, B.Com is an ideal foundation for CA (Chartered Accountancy) course. Many students pursue CA alongside or after B.Com.</p>
            </div>
        ',
        'key_info' => [
            'Duration' => '3 Years (6 Semesters)',
            'Total Marks' => 'Varies by University',
            'Exam Pattern' => 'Merit-based or Entrance Exam',
            'Languages' => 'English, Hindi',
            'Colleges Available' => '2000+ commerce colleges',
            'Top Colleges' => 'DU, IPU, Mumbai University',
            'Average Fees' => '₹20,000 - ₹1,50,000 per year'
        ],
        'specializations' => [
            'Accounting' => 'ACC',
            'Finance' => 'FIN',
            'Taxation' => 'TAX',
            'Banking' => 'BNK',
            'Insurance' => 'INS'
        ],
        'updates' => [
            [
                'title' => 'B.Com Admission 2026 - Applications Open',
                'date' => '2026-01-15',
                'author' => 'Eduspray Team',
                'content' => 'B.Com admission applications are now open for 2026. Check out top colleges and admission procedures.'
            ]
        ]
    ],
    
    'aviation' => [
        'name' => 'Aviation',
        'full_name' => 'Aviation & Pilot Training',
        'icon' => 'fas fa-plane',
        'duration' => '2-4 Years',
        'avg_fees' => '₹5,00,000 - ₹40,00,000 total',
        'short_description' => 'Aviation courses train students to become pilots, cabin crew, and aviation professionals.',
        'description' => '
            <p>Aviation is one of the most prestigious career paths, offering opportunities to fly aircraft or work in the exciting aviation industry. From commercial pilots to ground staff, the industry offers diverse roles.</p>
            
            <h4>Why Choose Aviation?</h4>
            <ul>
                <li><strong>Prestigious Career:</strong> Pilots are highly respected</li>
                <li><strong>Excellent Pay:</strong> Some of the highest salaries in any profession</li>
                <li><strong>Travel the World:</strong> Explore destinations globally</li>
                <li><strong>Growing Industry:</strong> India\'s aviation sector expanding rapidly</li>
            </ul>
        ',
        'eligibility' => '
            <h4>For Commercial Pilot License (CPL)</h4>
            <ul>
                <li>10+2 with Physics and Mathematics</li>
                <li>Minimum 50% marks</li>
                <li>Age: 17-65 years</li>
                <li>Medical fitness (Class 1 Medical Certificate)</li>
            </ul>
            
            <h4>For Cabin Crew/Ground Staff</h4>
            <ul>
                <li>10+2 from any stream</li>
                <li>Good height and communication skills</li>
            </ul>
        ',
        'career_options' => '
            <h4>Top Career Paths</h4>
            <div class="career-grid">
                <div class="career-card">
                    <i class="fas fa-plane-departure"></i>
                    <h5>Commercial Pilot</h5>
                    <p>₹15-80 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-user-tie"></i>
                    <h5>Cabin Crew</h5>
                    <p>₹4-12 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-tower-broadcast"></i>
                    <h5>Air Traffic Controller</h5>
                    <p>₹8-25 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-tools"></i>
                    <h5>Aircraft Maintenance</h5>
                    <p>₹5-15 LPA</p>
                </div>
            </div>
            
            <h4>Top Recruiters</h4>
            <p>Air India, IndiGo, SpiceJet, Vistara, GoAir, Jet Airways, and international airlines.</p>
            
            <h4>Higher Studies Options</h4>
            <ul>
                <li><strong>Advanced Pilot Training:</strong> Type ratings, instrument ratings</li>
                <li><strong>Aviation Management:</strong> MBA in Aviation Management</li>
                <li><strong>International Programs:</strong> Training from international aviation schools</li>
            </ul>
        ',
        'syllabus' => '
            <h4>Aviation Courses Syllabus Overview</h4>
            <p>Aviation courses cover flight training, aircraft systems, navigation, meteorology, and aviation regulations.</p>
            
            <h4>Core Subjects</h4>
            <ul>
                <li>Flight Training</li>
                <li>Aircraft Systems</li>
                <li>Navigation</li>
                <li>Meteorology</li>
                <li>Aviation Regulations</li>
                <li>Air Traffic Control</li>
                <li>Aviation Safety</li>
            </ul>
        ',
        'preparation_tips' => '
            <h4>How to Prepare for Aviation Courses</h4>
            <p>Focus on Physics and Mathematics. Maintain physical fitness. Prepare for medical examinations. Research flight schools and their requirements.</p>
        ',
        'mock_tests' => '
            <h4>Mock Test Series</h4>
            <p>Practice tests for DGCA exams and airline selection processes.</p>
        ',
        'question_papers' => '
            <h4>Previous Year Question Papers</h4>
            <p>Solve previous year papers for DGCA exams if available.</p>
        ',
        'study_material' => '
            <h4>Study Material</h4>
            <p>DGCA study guides, aviation textbooks, and online resources for pilot training.</p>
        ',
        'faqs' => '
            <h4>Frequently Asked Questions (FAQs)</h4>
            
            <div class="faq-item">
                <h4>Q1. What is the cost of pilot training?</h4>
                <p><strong>A:</strong> Commercial Pilot License (CPL) training costs ₹15-40 lakhs depending on the flight school and location.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q2. What is the age limit for becoming a pilot?</h4>
                <p><strong>A:</strong> Minimum age is 17 years. Maximum age for commercial pilots is typically 65 years, but airlines may have their own age limits.</p>
            </div>
        ',
        'key_info' => [
            'Duration (CPL)' => '18-24 months',
            'Duration (Cabin Crew)' => '3-6 months',
            'Total Cost (CPL)' => '₹15-40 Lakhs',
            'Medical Requirement' => 'Class 1 Medical Certificate (for pilots)',
            'License Required' => 'DGCA CPL License',
            'Colleges Available' => '50+ aviation training institutes',
            'Top Institutes' => 'Indira Gandhi Rashtriya Uran Akademi, CAE, L3Harris',
            'Average Fees' => '₹5,00,000 - ₹40,00,000 total'
        ],
        'specializations' => [
            'Commercial Pilot' => 'CPL',
            'Cabin Crew' => 'CC',
            'Air Traffic Control' => 'ATC',
            'Aircraft Maintenance' => 'AM',
            'Aviation Management' => 'AMG'
        ],
        'updates' => [
            [
                'title' => 'Aviation Training 2026 - Applications Open',
                'date' => '2026-01-15',
                'author' => 'Eduspray Team',
                'content' => 'Aviation training applications are now open for 2026. Check out top flight schools and training programs.'
            ]
        ]
    ],
    
    'humanities' => [
        'name' => 'Humanities',
        'full_name' => 'Arts & Humanities',
        'icon' => 'fas fa-palette',
        'duration' => '3 Years',
        'avg_fees' => '₹15,000 - ₹1,00,000 per year',
        'short_description' => 'Humanities covers diverse fields including history, political science, psychology, sociology, and languages.',
        'description' => '
            <p>Humanities and Arts education develops critical thinking, communication, and analytical skills. It encompasses diverse fields from literature to psychology, preparing students for various career paths.</p>
            
            <h4>Why Choose Humanities?</h4>
            <ul>
                <li><strong>Diverse Subjects:</strong> Psychology, Political Science, History, Literature</li>
                <li><strong>Civil Services:</strong> Best preparation for UPSC and state PCS</li>
                <li><strong>Critical Thinking:</strong> Develop analytical and reasoning skills</li>
                <li><strong>Creative Careers:</strong> Writing, teaching, counseling, law</li>
            </ul>
        ',
        'eligibility' => '
            <h4>Academic Requirements</h4>
            <ul>
                <li>10+2 from any stream</li>
                <li>Minimum 45-50% aggregate marks</li>
            </ul>
        ',
        'career_options' => '
            <h4>Top Career Paths</h4>
            <div class="career-grid">
                <div class="career-card">
                    <i class="fas fa-landmark"></i>
                    <h5>Civil Services (IAS)</h5>
                    <p>₹8-25 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <h5>Teacher/Professor</h5>
                    <p>₹4-15 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-brain"></i>
                    <h5>Psychologist</h5>
                    <p>₹5-20 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-pen-fancy"></i>
                    <h5>Writer/Author</h5>
                    <p>Variable</p>
                </div>
            </div>
            
            <h4>Top Recruiters</h4>
            <p>Government services (UPSC, state PCS), educational institutions, NGOs, media houses, and research organizations.</p>
            
            <h4>Higher Studies Options</h4>
            <ul>
                <li><strong>MA:</strong> Master of Arts in various specializations</li>
                <li><strong>M.Phil/PhD:</strong> For research and academic careers</li>
                <li><strong>Law:</strong> LLB for legal careers</li>
                <li><strong>Civil Services:</strong> UPSC and state PCS</li>
            </ul>
        ',
        'syllabus' => '
            <h4>Humanities Syllabus Overview</h4>
            <p>The Humanities curriculum covers diverse subjects including History, Political Science, Psychology, Sociology, Literature, and Languages over 6 semesters.</p>
            
            <h4>Core Subjects</h4>
            <ul>
                <li>History</li>
                <li>Political Science</li>
                <li>Psychology</li>
                <li>Sociology</li>
                <li>Literature</li>
                <li>Philosophy</li>
                <li>Economics</li>
                <li>Languages</li>
            </ul>
        ',
        'preparation_tips' => '
            <h4>How to Prepare for Humanities Courses</h4>
            <p>Most humanities courses admit based on 12th marks. Focus on your chosen subjects. For competitive exams like UPSC, start early preparation.</p>
        ',
        'mock_tests' => '
            <h4>Mock Test Series</h4>
            <p>Take mock tests for competitive exams like UPSC, state PCS if you plan to pursue civil services.</p>
        ',
        'question_papers' => '
            <h4>Previous Year Question Papers</h4>
            <p>Solve previous year papers for competitive exams if applicable.</p>
        ',
        'study_material' => '
            <h4>Study Material</h4>
            <p>Focus on NCERT books for foundation. For competitive exams, refer to standard books recommended for UPSC and state PCS.</p>
        ',
        'faqs' => '
            <h4>Frequently Asked Questions (FAQs)</h4>
            
            <div class="faq-item">
                <h4>Q1. What are the career options after Humanities?</h4>
                <p><strong>A:</strong> After Humanities, you can pursue civil services, teaching, research, law, journalism, social work, and various other careers.</p>
            </div>
            
            <div class="faq-item">
                <h4>Q2. Is Humanities good for UPSC preparation?</h4>
                <p><strong>A:</strong> Yes, Humanities subjects like History, Political Science, and Geography are highly relevant for UPSC Civil Services examination.</p>
            </div>
        ',
        'key_info' => [
            'Duration' => '3 Years (6 Semesters)',
            'Total Marks' => 'Varies by University',
            'Exam Pattern' => 'Merit-based or Entrance Exam',
            'Languages' => 'English, Hindi, Regional Languages',
            'Colleges Available' => '1000+ humanities colleges',
            'Top Colleges' => 'DU, JNU, BHU, Calcutta University',
            'Average Fees' => '₹15,000 - ₹1,00,000 per year'
        ],
        'specializations' => [
            'History' => 'HIS',
            'Political Science' => 'POL',
            'Psychology' => 'PSY',
            'Sociology' => 'SOC',
            'Literature' => 'LIT',
            'Philosophy' => 'PHI'
        ],
        'updates' => [
            [
                'title' => 'Humanities Admission 2026 - Applications Open',
                'date' => '2026-01-15',
                'author' => 'Eduspray Team',
                'content' => 'Humanities admission applications are now open for 2026. Check out top colleges and admission procedures.'
            ]
        ]
    ],
    
    'bbe' => [
        'name' => 'BBE',
        'full_name' => 'Bachelor of Business Economics',
        'icon' => 'fas fa-chart-line',
        'duration' => '3 Years',
        'avg_fees' => '₹50,000 - ₹2,50,000 per year',
        'short_description' => 'BBE is a specialized undergraduate program combining business administration with economics.',
        'description' => '
            <p>Bachelor of Business Economics (BBE) is a 3-year program that combines business administration with economics, preparing students for careers in business analysis, finance, and economic consulting.</p>
            
            <h4>Why Choose BBE?</h4>
            <ul>
                <li><strong>Unique Combination:</strong> Business skills with economic analysis</li>
                <li><strong>Analytical Skills:</strong> Develop strong analytical and quantitative skills</li>
                <li><strong>Career Opportunities:</strong> Business analyst, economic consultant, financial analyst</li>
                <li><strong>MBA Foundation:</strong> Excellent preparation for MBA programs</li>
            </ul>
        ',
        'eligibility' => '
            <h4>Academic Requirements</h4>
            <ul>
                <li>10+2 from any recognized board</li>
                <li>Minimum 50-60% aggregate marks</li>
                <li>Mathematics preferred</li>
            </ul>
            
            <h4>Entrance Exams</h4>
            <ul>
                <li><strong>DU JAT:</strong> Delhi University Joint Admission Test</li>
                <li><strong>IPU CET:</strong> For IPU affiliated colleges</li>
                <li><strong>CUET:</strong> Common University Entrance Test</li>
            </ul>
        ',
        'career_options' => '
            <h4>Top Career Paths</h4>
            <div class="career-grid">
                <div class="career-card">
                    <i class="fas fa-chart-line"></i>
                    <h5>Business Analyst</h5>
                    <p>₹6-18 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-dollar-sign"></i>
                    <h5>Economic Consultant</h5>
                    <p>₹5-15 LPA</p>
                </div>
                <div class="career-card">
                    <i class="fas fa-chart-pie"></i>
                    <h5>Financial Analyst</h5>
                    <p>₹5-20 LPA</p>
                </div>
            </div>
        ',
        'syllabus' => '<p>BBE curriculum covers microeconomics, macroeconomics, business statistics, financial management, and business analysis.</p>',
        'preparation_tips' => '<p>Focus on Mathematics, English, and General Knowledge. Practice logical reasoning and quantitative aptitude.</p>',
        'mock_tests' => '<p>Take regular mock tests from official websites and online platforms.</p>',
        'question_papers' => '<p>Solve previous year papers to understand exam pattern.</p>',
        'study_material' => '<p>Recommended books on economics, business studies, and quantitative aptitude.</p>',
        'faqs' => '
            <div class="faq-item">
                <h4>Q1. What is the difference between BBE and BBA?</h4>
                <p><strong>A:</strong> BBE focuses more on economics and quantitative analysis, while BBA focuses on general business management.</p>
            </div>
        ',
        'key_info' => [
            'Duration' => '3 Years',
            'Colleges Available' => '50+ colleges',
            'Top Colleges' => 'DU, IPU',
            'Average Fees' => '₹50,000 - ₹2,50,000 per year'
        ],
        'specializations' => [
            'Business Economics' => 'BE',
            'Financial Economics' => 'FE',
            'Applied Economics' => 'AE'
        ],
        'updates' => []
    ],
    
    'bajmc' => [
        'name' => 'BA-JMC',
        'full_name' => 'Bachelor of Arts in Journalism & Mass Communication',
        'icon' => 'fas fa-newspaper',
        'duration' => '3 Years',
        'avg_fees' => '₹30,000 - ₹2,00,000 per year',
        'short_description' => 'BA-JMC is a 3-year program in journalism and mass communication.',
        'description' => '<p>BA-JMC is similar to Journalism course, focusing on news reporting, broadcasting, and media communication.</p>',
        'eligibility' => '<p>10+2 from any stream with minimum 50% marks.</p>',
        'career_options' => '<p>Journalist, News Anchor, Video Editor, Social Media Manager.</p>',
        'syllabus' => '<p>News writing, broadcasting, digital media, advertising, and public relations.</p>',
        'preparation_tips' => '<p>Focus on English, General Knowledge, and Communication Skills.</p>',
        'mock_tests' => '<p>Take regular mock tests.</p>',
        'question_papers' => '<p>Solve previous year papers.</p>',
        'study_material' => '<p>Read newspapers daily and practice writing.</p>',
        'faqs' => '<p>FAQs similar to Journalism course.</p>',
        'key_info' => [
            'Duration' => '3 Years',
            'Colleges Available' => '200+ colleges',
            'Average Fees' => '₹30,000 - ₹2,00,000 per year'
        ],
        'specializations' => [
            'Print Journalism' => 'PJ',
            'Broadcast Journalism' => 'BJ',
            'Digital Media' => 'DM'
        ],
        'updates' => []
    ],
    
    'baeng' => [
        'name' => 'BA-Eng',
        'full_name' => 'Bachelor of Arts in English',
        'icon' => 'fas fa-book',
        'duration' => '3 Years',
        'avg_fees' => '₹20,000 - ₹1,50,000 per year',
        'short_description' => 'BA English is a 3-year program focusing on English literature and language.',
        'description' => '<p>BA English provides comprehensive study of English literature, language, and critical analysis.</p>',
        'eligibility' => '<p>10+2 from any stream with minimum 45-50% marks.</p>',
        'career_options' => '<p>Teacher, Writer, Editor, Content Writer, Translator.</p>',
        'syllabus' => '<p>English literature, language, poetry, drama, novels, and critical theory.</p>',
        'preparation_tips' => '<p>Read English literature, improve vocabulary, and practice writing.</p>',
        'mock_tests' => '<p>Take mock tests if entrance exam is required.</p>',
        'question_papers' => '<p>Solve previous year papers if available.</p>',
        'study_material' => '<p>Read classic and contemporary English literature.</p>',
        'faqs' => '<p>FAQs about BA English program.</p>',
        'key_info' => [
            'Duration' => '3 Years',
            'Colleges Available' => '500+ colleges',
            'Average Fees' => '₹20,000 - ₹1,50,000 per year'
        ],
        'specializations' => [
            'English Literature' => 'LIT',
            'Linguistics' => 'LING',
            'Creative Writing' => 'CW'
        ],
        'updates' => []
    ],
    
    'engineering' => [
        'name' => 'Engineering',
        'full_name' => 'Engineering Courses',
        'icon' => 'fas fa-cogs',
        'duration' => '4 Years',
        'avg_fees' => '₹1,00,000 - ₹4,00,000 per year',
        'short_description' => 'Engineering courses prepare students for technical careers in various engineering disciplines.',
        'description' => '<p>Engineering courses are similar to B.Tech, offering comprehensive education in various engineering disciplines.</p>',
        'eligibility' => '<p>10+2 with Physics, Chemistry, and Mathematics with minimum 60% marks.</p>',
        'career_options' => '<p>Engineer, Software Developer, Data Scientist, System Analyst.</p>',
        'syllabus' => '<p>Engineering curriculum similar to B.Tech covering various engineering disciplines.</p>',
        'preparation_tips' => '<p>Prepare for JEE Main, JEE Advanced, or state-level engineering entrance exams.</p>',
        'mock_tests' => '<p>Take regular mock tests for engineering entrance exams.</p>',
        'question_papers' => '<p>Solve previous year JEE papers.</p>',
        'study_material' => '<p>NCERT books, HC Verma, RD Sharma, and other engineering preparation books.</p>',
        'faqs' => '<p>FAQs similar to B.Tech course.</p>',
        'key_info' => [
            'Duration' => '4 Years',
            'Colleges Available' => '1000+ engineering colleges',
            'Average Fees' => '₹1,00,000 - ₹4,00,000 per year'
        ],
        'specializations' => [
            'Computer Science' => 'CSE',
            'Mechanical' => 'ME',
            'Civil' => 'CE',
            'Electrical' => 'EE'
        ],
        'updates' => []
    ],
    
    'management' => [
        'name' => 'Business & Management',
        'full_name' => 'Business & Management Courses',
        'icon' => 'fas fa-users-cog',
        'duration' => '3-4 Years',
        'avg_fees' => '₹50,000 - ₹3,00,000 per year',
        'short_description' => 'Business and Management courses prepare students for careers in business administration and management.',
        'description' => '<p>Business and Management courses include BBA, BBM, and other management programs.</p>',
        'eligibility' => '<p>10+2 from any stream with minimum 50% marks.</p>',
        'career_options' => '<p>Business Manager, Marketing Manager, HR Manager, Business Analyst.</p>',
        'syllabus' => '<p>Business management, marketing, finance, human resources, and operations management.</p>',
        'preparation_tips' => '<p>Focus on English, Mathematics, and General Knowledge for entrance exams.</p>',
        'mock_tests' => '<p>Take regular mock tests.</p>',
        'question_papers' => '<p>Solve previous year papers.</p>',
        'study_material' => '<p>Business management books and study materials.</p>',
        'faqs' => '<p>FAQs similar to BBA course.</p>',
        'key_info' => [
            'Duration' => '3-4 Years',
            'Colleges Available' => '1000+ management colleges',
            'Average Fees' => '₹50,000 - ₹3,00,000 per year'
        ],
        'specializations' => [
            'Marketing' => 'MKT',
            'Finance' => 'FIN',
            'Human Resources' => 'HR',
            'Operations' => 'OPS'
        ],
        'updates' => []
    ],
    
    'architecture' => [
        'name' => 'Architecture',
        'full_name' => 'Architecture & Design',
        'icon' => 'fas fa-drafting-compass',
        'duration' => '5 Years',
        'avg_fees' => '₹1,00,000 - ₹3,50,000 per year',
        'short_description' => 'Architecture courses prepare students for careers in architectural design and planning.',
        'description' => '<p>Architecture courses are similar to B.Arch, focusing on architectural design and planning.</p>',
        'eligibility' => '<p>10+2 with Mathematics with minimum 50% marks. NATA or JEE Main Paper 2 required.</p>',
        'career_options' => '<p>Architect, Urban Planner, Landscape Architect, Interior Architect.</p>',
        'syllabus' => '<p>Architectural design, building construction, history of architecture, and planning.</p>',
        'preparation_tips' => '<p>Prepare for NATA and JEE Main Paper 2. Practice drawing and sketching regularly.</p>',
        'mock_tests' => '<p>Take regular mock tests for NATA and JEE Main Paper 2.</p>',
        'question_papers' => '<p>Solve previous year NATA and JEE Main Paper 2 papers.</p>',
        'study_material' => '<p>NATA preparation books, drawing practice materials, and architectural awareness resources.</p>',
        'faqs' => '<p>FAQs similar to B.Arch course.</p>',
        'key_info' => [
            'Duration' => '5 Years',
            'Colleges Available' => '400+ architecture colleges',
            'Average Fees' => '₹1,00,000 - ₹3,50,000 per year'
        ],
        'specializations' => [
            'Urban Planning' => 'UP',
            'Landscape Architecture' => 'LA',
            'Interior Architecture' => 'IA'
        ],
        'updates' => []
    ]
];

// Default content for courses not in the predefined list
$DEFAULT_COURSE_DATA = [
    'description' => '
        <p>This course offers comprehensive education and training in the respective field. Students will gain theoretical knowledge and practical skills required for a successful career.</p>
        
        <h4>Why Choose This Course?</h4>
        <ul>
            <li>Industry-relevant curriculum</li>
            <li>Experienced faculty</li>
            <li>Practical training opportunities</li>
            <li>Good placement assistance</li>
        </ul>
    ',
    'eligibility' => '
        <h4>Academic Requirements</h4>
        <ul>
            <li>10+2 from any recognized board</li>
            <li>Minimum percentage as per university norms</li>
            <li>Entrance exam may be required</li>
        </ul>
    ',
    'career_options' => '
        <h4>Career Opportunities</h4>
        <p>Graduates can pursue various career paths in related industries. Specific opportunities depend on the course specialization and individual skills.</p>
    ',
    'syllabus' => '<p>Syllabus information will be updated soon.</p>',
    'preparation_tips' => '<p>Preparation tips will be updated soon.</p>',
    'mock_tests' => '<p>Mock test information will be updated soon.</p>',
    'question_papers' => '<p>Question paper information will be updated soon.</p>',
    'study_material' => '<p>Study material information will be updated soon.</p>',
    'faqs' => '<p>FAQs will be updated soon.</p>',
    'key_info' => [],
    'specializations' => [],
    'updates' => []
];

/**
 * Get course data by slug
 * @param string $slug Course slug
 * @return array Course data
 */
function getCourseContent($slug) {
    global $COURSES_DATA, $DEFAULT_COURSE_DATA;
    
    if (isset($COURSES_DATA[$slug])) {
        return $COURSES_DATA[$slug];
    }
    
    return $DEFAULT_COURSE_DATA;
}
?>





