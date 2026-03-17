variable "region" {
  default = "eu-north-1"
}

variable "instance_type" {
  default = "t3.micro"
}

variable "key_name" {
  description = "Your existing AWS key pair name"
  default     = "note-key" # 🔴 CHANGE THIS
}