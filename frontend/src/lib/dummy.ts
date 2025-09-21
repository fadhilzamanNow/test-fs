export type statusRencanaProduksi = "draft" | "pending" | "approved" | "rejected";

export const rencanaProduksiHead = ["No", "Product", "Jumlah", "Tanggal", "Status"]

export interface RencanaProduksi {
  plan_no: string;
  product: string;
  quantity: number;
  due_date: string;
  status: statusRencanaProduksi;
}

export const rencanaProduksiData: RencanaProduksi[] = [
  {
    plan_no: "PL-2025-0001",
    product: "Kotak",
    quantity: 200,
    due_date: "2025-09-28T00:00:00+07:00",
    status: "draft"
  },
  {
    plan_no: "PL-2025-0002",
    product: "Botol",
    quantity: 500,
    due_date: "2025-09-30T00:00:00+07:00",
    status: "pending"
  },
  {
    plan_no: "PL-2025-0003",
    product: "Sesuatu",
    quantity: 150,
    due_date: "2025-10-01T00:00:00+07:00",
    status: "approved"
  },
  {
    plan_no: "PL-2025-0004",
    product: "Gelas",
    quantity: 320,
    due_date: "2025-10-03T00:00:00+07:00",
    status: "rejected"
  },
  {
    plan_no: "PL-2025-0005",
    product: "Kotak Besar",
    quantity: 100,
    due_date: "2025-10-05T00:00:00+07:00",
    status: "pending"
  },
  {
    plan_no: "PL-2025-0006",
    product: "Toples",
    quantity: 275,
    due_date: "2025-10-07T00:00:00+07:00",
    status: "approved"
  },
  {
    plan_no: "PL-2025-0007",
    product: "Kardus",
    quantity: 600,
    due_date: "2025-10-09T00:00:00+07:00",
    status: "draft"
  },
  {
    plan_no: "PL-2025-0008",
    product: "Tas",
    quantity: 90,
    due_date: "2025-10-10T00:00:00+07:00",
    status: "approved"
  },
  {
    plan_no: "PL-2025-0009",
    product: "Botol Kecil",
    quantity: 420,
    due_date: "2025-10-12T00:00:00+07:00",
    status: "pending"
  },
  {
    plan_no: "PL-2025-0010",
    product: "Karton",
    quantity: 250,
    due_date: "2025-10-15T00:00:00+07:00",
    status: "draft"
  }
];

