import { useEffect, useState } from "react";
import { FlatList, Text, View } from "react-native";

export default function HomeScreen() {
  const [products, setProducts] = useState([]);

  useEffect(() => {
    fetch("http://192.168.1.108:8081/api/products")
      .then(res => res.json())
      .then(data => setProducts(data))
      .catch(err => console.log(err));
  }, []);

  return (
    <View style={{ flex: 1, padding: 20, marginTop: 50 }}>
      <Text style={{ fontSize: 22, fontWeight: "bold" }}>
        ThriftHub Products
      </Text>

      <FlatList
        data={products}
        keyExtractor={(item) => item.id.toString()}
        renderItem={({ item }) => (
          <View style={{ padding: 10, borderBottomWidth: 1 }}>
            <Text>{item.title}</Text>
            <Text>₱{item.price}</Text>
          </View>
        )}
      />
    </View>
  );
}