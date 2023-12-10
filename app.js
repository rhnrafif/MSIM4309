new Vue({
    el: '#app',
    data: {
      dataKendaraan: [], // Data kendaraan dari server
      dataBaru: {
        nama_mobil: '',
        merk: '',
        warna: '',
        nopol: '',
        harga: ''
      }
    },
    mounted() {
      // Ambil data kendaraan dari server saat halaman dimuat
      this.getDataKendaraan();
    },
    methods: {
      getDataKendaraan() {
        // Mengambil data kendaraan dari server (PHP)
        fetch('api.php', { method: 'GET' })
          .then(response => response.json())
          .then(data => this.dataKendaraan = data)
          .catch(error => console.error('Error:', error));
      },
      tambahData() {
        // Menambahkan data baru ke dalam tabel kendaraan
        fetch('api.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.dataBaru)
        })
        .then(response => response.json())
        .then(data => {
          this.dataKendaraan.push(data);
          this.dataBaru = {
            nama_mobil: '',
            merk: '',
            warna: '',
            nopol: '',
            harga: ''
          };
        })
        .catch(error => console.error('Error:', error));
      },
      hapusData(id) {
        // Menghapus data kendaraan berdasarkan ID
        fetch('api.php', {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(() => {
          // Hapus data dari array lokal
          this.dataKendaraan = this.dataKendaraan.filter(kendaraan => kendaraan.id !== id);
        })
        .catch(error => console.error('Error:', error));
      }
    }
  });
  