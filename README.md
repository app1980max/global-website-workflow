<img width="1048" height="646" alt="image" src="https://github.com/user-attachments/assets/f6c5e6e8-e242-42f2-822c-fc0c00bb2554" />


## PHP | Wordpress Site 


🎯 Architecture Overview
```
✅ S3 input bucket (user uploads)
✅ Lambda Function (process + translate)
✅ S3 output bucket (results)
✅ IAM Role + Permissions
✅ CloudWatch Logs
```


🧱 Package Lambdas
```
cd functions
zip lambda_function.zip lambda_function.py
```


🚀 Deployment Options
```
terraform init
terraform validate
terraform plan -var-file="template.tfvars"
terraform apply -var-file="template.tfvars" -auto-approve
```

🔎 Query
```
curl -X POST https://zo1ehal9pf.execute-api.us-west-2.amazonaws.com/orders \
  -H "Content-Type: application/json" \
  -d '{
    "items": ["book"],
    "userEmail": "test@example.com"
  }'
```
