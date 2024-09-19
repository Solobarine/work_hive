export interface TaskInterface {
  id: number;
  title: string;
  description: string;
  status: "pending" | "ongoing" | "completed";
  priority: "high" | "medium" | "low";
}
