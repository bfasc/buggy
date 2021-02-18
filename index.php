<?php
    REQUIRE_ONCE 'assets/functions.php';
    printHead("Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar("notloggedin", "/"); ?>
    <div class="main" id="splash">
        <header>
            <img src="img/LOGO_MAIN.png">
            <h2>Collaborative & Intuitive Workspace</h2>

            <p>Buggy provides your team with an easy and efficient method to knock
                out your project's bugs with confidence.
            </p>

            <a href="purchase.html" class="button">Get Buggy for your team</a>
        </header>
        <section>
            <h1>Why choose buggy?</h1>
            <div class="third">
                <div>
                    <img src="img/SignUp.png">
                    <h3>Easy Setup</h3>
                </div>
                <p>It takes only a few minutes to create a Buggy account. Once
                    your account is created, your project’s custom link is
                    generated for your users to start reporting bugs ASAP.
                </p>
            </div>
            <div class="third">
                <div>
                    <img src="img/Collaboration.png">
                    <h3>Team Focused</h3>
                </div>
                <p>The Buggy interface revolves around collaboration among the
                    members of your team. With built-in discussion threads tied
                    to bug reports, everyone on your team is sure to be on the same page.
                </p>
            </div>
            <div class="third">
                <div>
                    <img src="img/intuitive.png">
                    <h3>Intuitive Interface</h3>
                </div>
                <p>One of the main goals of Buggy’s interface is to help users
                    have a good, easy-to-use experience when tracking and fixing
                    bugs. The Buggy interface has a smooth, intuitive feel that
                    makes it easy to quickly master.
                </p>
            </div>
        </section>

        <section>
            <h1>Easy to set up, easy to use.</h1>
            <div class="whole">
                <div class="section-img">
                    <img src="img/bugreport.png">
                </div>
                <p>Once you’ve created an account for your team and added a
                    Project, a report.buggy.com custom link will be generated.
                    Your users can click this link to take them to a simple,
                    easy-to-use form where they can submit information about a bug.
                    This information will go directly to your Project Manager’s
                    Buggy account, where they can accept/deny the bug. Once a
                    bug is accepted by the manager, it will be sent to a developer
                    to work on.
                </p>
            </div>
        </section>

        <section>
            <div class="half">
                <h1>Work Together</h1>
                <p>After a bug report is approved and assigned, developers are
                    able to collaborate directly in the Buggy software. Your
                    team can also view threads for past tickets in case they
                    run into any issues during a bug fix.
                </p>
            </div>
            <div class="half">
                <!-- NEED IMG -->
            </div>

        </section>

        <section>
            <h1>Let's get you started.</h1>
            <div class="padded">
                <h2>Purchase your plan</h2>
                <h3>$49.99/month</h3>
                <p>Unlimited Accounts</p>
                <p>Unlimited Bug Reports</p>
                <p>99.9% Uptime</p>
                <a href="purchase.html" class="button">Buy Now</a>
            </div>
        </section>
    </div>
    <?php printFooter("basic"); ?>

</body>
</html>
