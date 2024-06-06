export default function validateData(data: any) {
  if (data.status) {
    if (
      data.status !== "Published" &&
      data.status !== "Pending" &&
      data.status !== "Deleted"
    ) {
      return false;
    }
  }

  if (data.title && data.title === "") {
    return false;
  }
  if (data.description && data.description === "") {
    return false;
  }
  if (data.is_premium != null && typeof data.is_premium != typeof true) {
    return false;
  }

  return true;
}
