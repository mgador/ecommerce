<?php include('partials/__header.php'); ?>

<form action="submit_seller_registration.php" method="post">

    <!-- Company Information -->
    <input type="text" name="company_name" placeholder="Company Name" required>
    <input type="text" name="business_registration_number" placeholder="Business Registration Number">
    <input type="text" name="business_type" placeholder="Business Type">

    <!-- Contact Information -->
    <input type="text" name="contact_person_name" placeholder="Contact Person Name" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="tel" name="phone_number" placeholder="Phone Number">
    <input type="text" name="address" placeholder="Address">

    <!-- Account Credentials -->
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>

    <!-- Payment Information -->
    <input type="text" name="bank_account_details" placeholder="Bank Account Details">
    <input type="text" name="payment_gateway_info" placeholder="Payment Gateway Information">
    <input type="text" name="tax_id" placeholder="Tax ID or VAT Number">

    <!-- Product Information -->
    <input type="text" name="product_categories" placeholder="Product Categories">
    <textarea name="product_description" placeholder="Product Description"></textarea>
    <input type="number" name="pricing" placeholder="Pricing">
    <input type="number" name="inventory" placeholder="Inventory">

    <!-- Shipping Information -->
    <input type="text" name="shipping_options" placeholder="Shipping Options">
    <input type="number" name="shipping_rates" placeholder="Shipping Rates">
    <input type="text" name="shipping_destinations" placeholder="Shipping Destinations">

    <!-- Terms and Agreements -->
    <label><input type="checkbox" name="terms_of_service_agreed" required> I agree to the Terms of Service</label>
    <label><input type="checkbox" name="seller_agreement_agreed" required> I agree to the Seller Agreement</label>

    <!-- Verification and Security -->
    <input type="file" name="identity_verification_document" accept=".pdf,.jpg,.png">
    <input type="text" name="security_question" placeholder="Security Question">
    <input type="text" name="security_answer" placeholder="Security Answer">

    <!-- Additional Information -->
    <input type="url" name="social_media_profiles" placeholder="Social Media Profiles">
    <input type="text" name="referral_source" placeholder="Referral Source">
    <label><input type="checkbox" name="marketing_opt_in">I want to receive marketing emails</label>

    <input type="submit" value="Register">
    
</form>


<?php include('partials/__footer.php'); ?>