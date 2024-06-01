import { model, models, Schema } from "mongoose";

const CourseSchema = new Schema({
  id: {
    type: String,
    unique: [true, "ID already exists."],
    required: [true, "ID is required."],
  },
  title: {
    type: String,
    required: [true, "Title is required."],
  },
  description: {
    type: String,
    required: [true, "Description is required."],
  },
  status: {
    type: String,
    required: [true, "Status is required."],
  },
  is_premium: {
    type: Boolean,
    required: [true, "Is_Premium is required."],
  },
  created_at: {
    type: String,
    required: [true, "Date of creation is required."],
  },
  deleted_at: {
    type: String,
    required: [true, "Date of deletion is required."],
  },
});

const Course = models.Course || model("Course", CourseSchema);

export default Course;
