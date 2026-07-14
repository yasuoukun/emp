@extends('layouts.store')

@section('content')
<div class="fade-in" style="max-width: 1200px; margin: 0 auto; padding: 4rem 1.5rem; font-family: 'Prompt', sans-serif;">
    
    <!-- Hero Banner with Gradient -->
    <div style="background: linear-gradient(135deg, var(--color-navy-dark) 0%, var(--color-navy-light) 100%); border-radius: 24px; padding: 5rem 2rem; text-align: center; color: white; margin-bottom: 4rem; box-shadow: 0 20px 40px rgba(18, 28, 48, 0.15); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.03); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -50px; left: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%;"></div>
        
        <span style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); color: #E2E8F0; font-size: 0.9rem; font-weight: 600; padding: 8px 20px; border-radius: 30px; letter-spacing: 1px; display: inline-block; margin-bottom: 1.5rem;">ABOUT DDITCOM</span>
        <h1 style="font-size: 3rem; font-weight: 700; margin: 0 0 1.5rem 0; line-height: 1.2;">ดีดี.ไอที.คอม (DDITCOM)</h1>
        <p style="color: #CBD5E1; max-width: 800px; margin: 0 auto; font-size: 1.2rem; line-height: 1.7;">
            ศูนย์รวมมือถือและสินค้าไอทีครบวงจร เพื่อการเติบโตขององค์กรคุณอย่างยั่งยืน
        </p>
    </div>

    <!-- Corporate History Section -->
    <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 4rem; align-items: center; margin-bottom: 5rem;">
        <div>
            <h2 style="font-size: 2.2rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 1.5rem;">
                ความเป็นมาของเรา
                <span style="display: block; width: 60px; height: 4px; background: var(--color-accent); margin-top: 10px; border-radius: 2px;"></span>
            </h2>
            <p style="color: var(--color-grey); font-size: 1.05rem; line-height: 1.8; margin-bottom: 1.5rem;">
                <strong>บริษัท ดีดี.ไอที.คอม จำกัด (DD.IT.COM CO., LTD.)</strong> เราเป็นผู้นำด้านการจัดจำหน่ายสินค้าและโซลูชัน IT แบบครบวงจร รองรับทุกขนาดองค์กร ตั้งแต่ Home Office, SME ไปจนถึงระดับ Enterprise 
            </p>
            <p style="color: var(--color-grey); font-size: 1.05rem; line-height: 1.8; margin-bottom: 1.5rem;">
                บริษัทก่อตั้งขึ้นในปี พ.ศ. 2549 เริ่มต้นจากธุรกิจจำหน่ายโทรศัพท์มือถือและอุปกรณ์ไอทีในยุคเริ่มต้นของเทคโนโลยี ด้วยความมุ่งมั่นในการบริการอย่างมืออาชีพ เราเติบโตอย่างต่อเนื่องและพัฒนาเพื่อตอบสนองทุกความต้องการของลูกค้าในยุคดิจิทัลได้อย่างครอบคลุม ด้วยประสบการณ์ที่ยาวนานมากกว่า 19 ปี
            </p>
        </div>
        <div>
            <div style="background: white; border: 1px solid var(--color-silver); border-radius: 20px; padding: 2.5rem; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                <span style="font-size: 4rem; font-weight: 800; color: var(--color-accent); display: block; line-height: 1;">19+</span>
                <span style="font-size: 1.1rem; font-weight: 600; color: var(--color-navy-dark); display: block; margin-top: 10px; margin-bottom: 15px;">ปีแห่งประสบการณ์และความเชื่อมั่น</span>
                <p style="color: var(--color-grey); font-size: 0.9rem; line-height: 1.6; margin: 0;">
                    เราได้รับความไว้วางใจจากลูกค้ากว่าร้อยราย ทั้งหน่วยงานราชการ องค์กรเอกชน และลูกค้ารายย่อยทั่วไป
                </p>
            </div>
        </div>
    </div>

    <!-- Strengths Section: สิ่งที่ทำให้เราแตกต่าง -->
    <div style="background: white; border-radius: 24px; border: 1px solid var(--color-silver); padding: 3.5rem; margin-bottom: 5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <h2 style="font-size: 2rem; font-weight: 700; color: var(--color-navy-dark); text-align: center; margin-top: 0; margin-bottom: 3rem;">
            สิ่งที่ทำให้เราแตกต่าง
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            
            <div style="text-align: center; padding: 1rem;">
                <div style="width: 70px; height: 70px; background: rgba(49, 130, 206, 0.1); color: var(--color-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto; font-size: 2rem;">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 10px;">ความปลอดภัยสูงสุด</h3>
                <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.7; margin: 0;">
                    ปกป้องข้อมูลสำคัญขององค์กรด้วยระบบ MDM มาตรฐานสากล ควบคุมสิทธิ์การเข้าถึงและป้องกันข้อมูลรั่วไหลในทุกอุปกรณ์ได้อย่างรัดกุม
                </p>
            </div>

            <div style="text-align: center; padding: 1rem;">
                <div style="width: 70px; height: 70px; background: rgba(49, 130, 206, 0.1); color: var(--color-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto; font-size: 2rem;">
                    <i class="fa-solid fa-diagram-project"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 10px;">เชี่ยวชาญระบบองค์กร</h3>
                <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.7; margin: 0;">
                    ทีมวิศวกรผู้เชี่ยวชาญในการวางระบบ Apple Business Manager (ABM) และการตั้งค่าอุปกรณ์จำนวนมากแบบอัตโนมัติ (Zero-Touch Deployment)
                </p>
            </div>

            <div style="text-align: center; padding: 1rem;">
                <div style="width: 70px; height: 70px; background: rgba(49, 130, 206, 0.1); color: var(--color-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto; font-size: 2rem;">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 10px;">บริหารต้นทุนคุ้มค่า</h3>
                <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.7; margin: 0;">
                    นำเสนอโซลูชันที่ตอบโจทย์การลงทุน (ROI) ทั้งรูปแบบการจัดซื้อและการเช่าใช้อุปกรณ์ (DaaS) ช่วยองค์กรลดภาระค่าใช้จ่ายระยะยาว
                </p>
            </div>

            <div style="text-align: center; padding: 1rem;">
                <div style="width: 70px; height: 70px; background: rgba(49, 130, 206, 0.1); color: var(--color-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto; font-size: 2rem;">
                    <i class="fa-solid fa-people-carry-box"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 10px;">พันธมิตรพร้อมดูแล</h3>
                <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.7; margin: 0;">
                    เคียงข้างธุรกิจคุณด้วยบริการ IT Support ระดับ Enterprise ทั้งการดูแลรักษาระบบ (MA) และให้คำปรึกษาอย่างต่อเนื่องและไว้ใจได้
                </p>
            </div>

        </div>
    </div>

    <!-- Vision & Mission Section -->
    <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 3.5rem; margin-bottom: 5rem;">
        
        <!-- Vision -->
        <div style="background: linear-gradient(135deg, var(--color-navy-light) 0%, var(--color-navy-dark) 100%); border-radius: 20px; padding: 3rem 2.5rem; color: white; box-shadow: 0 10px 35px rgba(18,28,48,0.1);">
            <div style="font-size: 2.2rem; margin-bottom: 1rem; color: #E2E8F0;"><i class="fa-regular fa-eye"></i></div>
            <h2 style="font-size: 1.8rem; font-weight: 700; margin-top: 0; margin-bottom: 1.5rem;">วิสัยทัศน์ (Vision)</h2>
            <p style="font-size: 1.1rem; line-height: 1.8; color: #E2E8F0; font-style: italic; margin: 0;">
                "มุ่งสู่การเป็นผู้นำด้านการจัดจำหน่ายสินค้าไอทีและโทรศัพท์มือถือที่ลูกค้าไว้วางใจมากที่สุดในประเทศไทย ด้วยบริการที่เป็นเลิศ สินค้าคุณภาพ และเทคโนโลยีล้ำสมัย"
            </p>
        </div>

        <!-- Mission -->
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 20px; padding: 3rem 2.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.01);">
            <div style="font-size: 2.2rem; margin-bottom: 1rem; color: var(--color-accent);"><i class="fa-solid fa-bullseye"></i></div>
            <h2 style="font-size: 1.8rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 1.5rem;">พันธกิจ (Mission)</h2>
            <ul style="color: var(--color-grey); font-size: 1rem; line-height: 1.8; padding-left: 20px; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                <li><strong>จัดจำหน่ายสินค้าไอทีและโทรศัพท์มือถือคุณภาพ</strong> จากแบรนด์ชั้นนำ พร้อมรับประกันความพึงพอใจ</li>
                <li><strong>ให้บริการลูกค้าอย่างมืออาชีพ</strong> ด้วยความจริงใจ รวดเร็ว และเป็นกันเอง</li>
                <li><strong>พัฒนาระบบการขายออนไลน์และหน้าร้านให้ทันสมัย</strong> รองรับทุกความต้องการของลูกค้าในยุคดิจิทัล</li>
                <li><strong>สร้างประสบการณ์การซื้อขายที่เหนือความคาดหมาย</strong> ด้วยโปรโมชั่นดี ราคาคุ้มค่า และบริการหลังการขายที่ไว้ใจได้</li>
            </ul>
        </div>

    </div>

    <!-- Trusted IT Partner Block -->
    <div style="background: var(--color-grey-bg); border-radius: 24px; border: 1px solid var(--color-silver); padding: 3.5rem; text-align: center; margin-bottom: 5rem;">
        <h3 style="font-size: 1.8rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 1.2rem;">
            พันธมิตรด้านเทคโนโลยีที่คุณไว้วางใจ (Your Trusted IT Partner)
        </h3>
        <p style="color: var(--color-grey); max-width: 900px; margin: 0 auto; font-size: 1.05rem; line-height: 1.8;">
            <strong>AUTHORIZED IT SOLUTION:</strong> ดีดี.ไอที.คอม (DDITCOM) คือผู้ให้บริการโซลูชันด้านไอทีระดับองค์กรแบบครบวงจรในจังหวัดชัยภูมิ เราเชี่ยวชาญในการวางระบบ Enterprise IT, การจัดการอุปกรณ์องค์กร (MDM & Apple Business Manager) และบริการดูแลรักษาระบบ (IT Maintenance) เราพร้อมนำเสนอเทคโนโลยีที่ทันสมัย เพื่อยกระดับมาตรฐานความปลอดภัยและเพิ่มประสิทธิภาพการทำงานให้กับหน่วยงานและธุรกิจของคุณ
        </p>
    </div>

    <!-- Contact & Operating Hours Section -->
    <div style="background: white; border: 1px solid var(--color-silver); border-radius: 24px; padding: 3.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02); display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
        <div>
            <h2 style="font-size: 2rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 1.5rem;">
                ข้อมูลติดต่อเรา
            </h2>
            <div style="display: flex; flex-direction: column; gap: 1.2rem; color: var(--color-grey); font-size: 1rem;">
                <div style="display: flex; gap: 15px; align-items: flex-start;">
                    <span style="color: var(--color-accent); font-size: 1.2rem;"><i class="fa-solid fa-location-dot"></i></span>
                    <span>
                        <strong>บริษัท ดีดี.ไอที.คอม จำกัด (DD.IT.COM CO., LTD.)</strong><br>
                        ที่อยู่ 72/47-48ก ถนนชัยประสิทธิ์ ต.ในเมือง อ.เมือง จ.ชัยภูมิ 36000
                    </span>
                </div>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span style="color: var(--color-accent); font-size: 1.2rem;"><i class="fa-solid fa-clock"></i></span>
                    <span><strong>เวลาทำการ:</strong> จันทร์ - อาทิตย์ เวลา 09.00 - 19.00 น.</span>
                </div>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span style="color: var(--color-accent); font-size: 1.2rem;"><i class="fa-solid fa-phone"></i></span>
                    <span><strong>เบอร์โทร:</strong> 083-8289414, 044-822388</span>
                </div>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span style="color: var(--color-accent); font-size: 1.2rem;"><i class="fa-solid fa-envelope"></i></span>
                    <span><strong>อีเมล:</strong> jirawat@dditcom.co.th</span>
                </div>
            </div>
        </div>
        
        <div style="text-align: center; background: var(--color-grey-bg); border-radius: 20px; padding: 3rem 2rem; border: 1px solid var(--color-silver-light);">
            <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; margin-bottom: 1rem; font-size: 1.4rem;">เชื่อมต่อกับเรา</h3>
            <p style="color: var(--color-grey); font-size: 0.95rem; margin-bottom: 2rem;">
                มีคำถามเพิ่มเติม ต้องการให้ทีมขายติดต่อกลับ หรือต้องการส่งเครื่องเก่ามาเปลี่ยนใหม่?
            </p>
            <a href="https://line.me/ti/p/@dditcom" target="_blank" style="background: #06c755; color: white; text-decoration: none; padding: 14px 28px; border-radius: 12px; font-weight: 600; font-size: 1.05rem; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 10px; width: 100%; justify-content: center; box-shadow: 0 4px 15px rgba(6,199,85,0.25);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="fa-brands fa-line" style="font-size: 1.3rem;"></i> แชทคุยกับทีมงานทาง Line
            </a>
        </div>
    </div>

</div>
@endsection
