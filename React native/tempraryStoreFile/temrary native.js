//* dd
//* dd
//* dd
//* dd

import React, { useEffect, useState } from 'react';
import { View, StyleSheet, Text } from 'react-native';

const App = () => {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true); // Add loading state
  const [error, setError] = useState(null); // Add error state

  const getAPIData = async () => {
  
    try {
      const url = 'https://jsonplaceholder.typicode.com/posts';
      // console.warn('Fetching data from:', url);
      let response = await fetch(url);
      console.warn('Response Status:', response); // Log status code
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      let result = await response.json();
      console.warn('Fetched Data:', result); // Log fetched data
      setData(result);
      setLoading(false);
    } catch (error) {
      console.error('There was a problem with the fetch operation:', error);
      setError(error.message);
      setLoading(false);
    }
  };
  
  useEffect(() => {
    getAPIData();
  }, []);

  return (
    <View style={styles.container}>
      <Text>Home Screen 3</Text>
      {loading && <Text>Loading...</Text>}
      {error && <Text style={styles.errorText}>Error: {error}</Text>}
      {data.length > 0 && (
        <Text>Data fetched successfully: {JSON.stringify(data[0])}</Text>
      )}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 16,
    backgroundColor: '#f0f0f0',
  },
  errorText: {
    color: 'red',
    marginTop: 10,
  },
});

export default App;

//* dd
import * as React from 'react';
import { Button, View, StyleSheet } from 'react-native';
import { createDrawerNavigator } from '@react-navigation/drawer';
import { NavigationContainer } from '@react-navigation/native';
import LinearGradient from 'react-native-linear-gradient';

function HomeScreen({ navigation }) {
  return (
    <LinearGradient
      colors={['#ff69b4', '#87ceeb', '#ff6347']} // Pink, Blue, Red
      style={styles.gradient}
    >
      <View style={styles.container}>
        <Button
          onPress={() => navigation.navigate('Notifications')}
          title="Go to notifications"
        />
      </View>
    </LinearGradient>
  );
}

function NotificationsScreen({ navigation }) {
  return (
    <View style={styles.container}>
      <Button onPress={() => navigation.goBack()} title="Go back home" />
    </View>
  );
}

const Drawer = createDrawerNavigator();

function App() {
  return (
    <NavigationContainer>
      <Drawer.Navigator initialRouteName="Home">
        <Drawer.Screen name="Home" component={HomeScreen} />
        <Drawer.Screen name="Notifications" component={NotificationsScreen} />
        <Drawer.Screen name="shahid" component={NotificationsScreen} />
      </Drawer.Navigator>
    </NavigationContainer>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
  gradient: {
    flex: 1,
  },
});

export default App;

//* dd
// module.exports = {
//   presets: ['module:@react-native/babel-preset'],
// };

// module.exports = {
//   presets: ['module:metro-react-native-babel-preset'],
//   plugins: ['react-native-reanimated/plugin'],
// };
module.exports = {
  presets: ['module:metro-react-native-babel-preset'],
  plugins: [
    'react-native-reanimated/plugin',
    '@babel/plugin-transform-private-methods'
  ],
};




import React, { useState } from 'react';
import { Alert, Button, TextInput, Modal, StyleSheet, Text, Pressable, View } from 'react-native';

const App = () => {
  const [modalVisible, setModalVisible] = useState(false);
  const [input1, setInput1] = useState('');
  const [input2, setInput2] = useState('');

  return (
    <View style={styles.centeredView}>
      <Modal
        animationType="slide"
        transparent={true}
        visible={modalVisible}
        onRequestClose={() => {
          // Alert.alert('Modal has been closed.');
          setModalVisible(!modalVisible);
        }}>
        <View style={styles.centeredView}>
          <View style={styles.modalView}>
            <Text style={styles.modalText}>Hello World!</Text>

            <TextInput
              style={styles.input}
              placeholder="Input 1"
              value={input1}
              onChangeText={setInput1}
            />
            <TextInput
              style={styles.input}
              placeholder="Input 2"
              value={input2}
              onChangeText={setInput2}
            />
            {/* <Button title='Save' color="#4CAF50" /> */}

            <Pressable
              style={[styles.button, styles.buttonSave]}>
              <Text style={styles.textStyle}>Save</Text>
            </Pressable>

            <Pressable
              style={[styles.button, styles.buttonClose]}
              onPress={() => setModalVisible(!modalVisible)}>
              <Text style={styles.textStyle}>Hide Modal</Text>
            </Pressable>
          </View>
        </View>
      </Modal>

      {/* <Button onPress={() => openModal(item)} title='Update' color="#4CAF50" /> */}
      <Pressable
        style={[styles.button, styles.buttonOpen]}
        onPress={() => setModalVisible(true)}>
        <Text style={styles.textStyle}>Update</Text>
      </Pressable>
    </View>
  );
};


const styles = StyleSheet.create({
  centeredView: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: 22,
  },
  modalView: {
    margin: 20,
    backgroundColor: 'white',
    borderRadius: 20,
    padding: 35,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 4,
    elevation: 5,
    width: '90%',
  },
  button: {
    borderRadius: 20,
    padding: 10,
    elevation: 2,
  },
  buttonOpen: {
    backgroundColor: '#F194FF',
  },
  buttonClose: {
    backgroundColor: '#2196F3',
  },
  buttonSave: {
    marginBottom: 15,
    backgroundColor: '#4CAF50',
  },
  textStyle: {
    color: 'white',
    fontWeight: 'bold',
    textAlign: 'center',
  },
  modalText: {
    marginBottom: 15,
    textAlign: 'center',
  },
  input: {
    height: 40,
    borderColor: '#ccc',
    borderBottomWidth: 1,
    marginBottom: 15,
    paddingHorizontal: 10,
    width: '100%',
  },
});

export default App;







2222222222222222222222222222222222
import React, { useEffect, useState } from 'react';
import { Alert, Pressable, Button, Text, TextInput, View, StyleSheet, ScrollView, Modal } from 'react-native';

const App = () => {
  const [data, setData] = useState([]);

  const [modalVisible, setModalVisible] = useState(false);
  const [selectedUser, setSelectedUser] = useState(null);
  const [name, setName] = useState('');
  const [color, setColor] = useState('');
  const [searchText, setSearchText] = useState('');

  const getAPIData = async () => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    setData(result);
  };

  useEffect(() => {
    getAPIData();
  }, []);

  const deleteUser = async (id) => {
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(`${url}/${id}`, {
      method: "DELETE"
    });
    result = await result.json();
    if (result) {
      console.warn("User deleted");
      getAPIData();
    }
  };

  const updateUser = async () => {
    if (!selectedUser) return;

    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(`${url}/${selectedUser.id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ name, color })
    });
    result = await result.json();
    if (result) {
      console.warn("User updated");
      setModalVisible(false);
      getAPIData();
    }
  };

  const searchUser = async (text) => {
    setSearchText(text);
    const url = "http://10.0.2.2:3000/users";
    let result = await fetch(url);
    result = await result.json();
    const filteredData = result.filter(user =>
      user.name.toLowerCase().includes(text.toLowerCase()) ||
      user.color.toLowerCase().includes(text.toLowerCase())
    );
    setData(filteredData);
  };

  const openModal = (user) => {
    setSelectedUser(user);
    setName(user.name);
    setColor(user.color);
    setModalVisible(true);
  };

  return (
    <View style={styles.container}>
      <View>
        <TextInput
          style={styles.input}
          placeholder="Search"
          value={searchText}
          onChangeText={(text) => searchUser(text)}
        />
      </View>

      <ScrollView>
        {data.length ? (
          data.map((item) => (
            <View key={item.id} style={styles.itemContainer}>
              <Text style={styles.itemText}>ID: {item.id}</Text>
              <Text style={styles.itemText}>Name: {item.name}</Text>
              <Text style={styles.itemText}>Color: {item.color}</Text>
              <View style={styles.buttonRow}>
                <Button onPress={() => deleteUser(item.id)} title='Delete' color="#ff5c5c" />
                <Pressable
                  style={[styles.button, styles.buttonOpen]}
                  onPress={() => openModal(item)}>
                  <Text style={styles.textStyle}>Update</Text>
                </Pressable>
              </View>
            </View>
          ))
        ) : (
          <Text style={styles.noDataText}>No data available</Text>
        )}

        <Modal
          animationType="slide"
          transparent={true}
          visible={modalVisible}
          onRequestClose={() => {
            setModalVisible(!modalVisible);
          }}>
          <View style={styles.centeredView}>
            <View style={styles.modalView}>
              <Text style={styles.modalText}>Update User</Text>
              <TextInput
                style={styles.input}
                placeholder="Name"
                value={name}
                onChangeText={setName}
              />
              <TextInput
                style={styles.input}
                placeholder="Color"
                value={color}
                onChangeText={setColor}
              />

              <Pressable
                style={[styles.button, styles.buttonSave]} onPress={updateUser}>
                <Text style={styles.textStyle}>Save</Text>
              </Pressable>

              <Pressable
                style={[styles.button, styles.buttonClose]}
                onPress={() => setModalVisible(!modalVisible)}>
                <Text style={styles.textStyle}>Hide Modal</Text>
              </Pressable>
            </View>
          </View>
        </Modal>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
  },
  itemContainer: {
    marginBottom: 15,
    padding: 10,
    borderWidth: 1,
    borderColor: '#ddd',
    borderRadius: 10,
  },
  itemText: {
    fontSize: 16,
  },
  buttonRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  noDataText: {
    textAlign: 'center',
    fontSize: 18,
    marginTop: 20,
  },
  centeredView: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  modalView: {
    margin: 20,
    backgroundColor: 'white',
    borderRadius: 20,
    padding: 35,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 4,
    elevation: 5,
    width: '90%',
  },
  button: {
    borderRadius: 20,
    padding: 10,
    elevation: 2,
  },
  buttonOpen: {
    backgroundColor: '#F194FF',
  },
  buttonClose: {
    backgroundColor: '#2196F3',
  },
  buttonSave: {
    marginBottom: 15,
    backgroundColor: '#4CAF50',
  },
  textStyle: {
    color: 'white',
    fontWeight: 'bold',
    textAlign: 'center',
  },
  modalText: {
    marginBottom: 15,
    textAlign: 'center',
  },
  input: {
    height: 40,
    borderColor: '#ccc',
    borderBottomWidth: 1,
    marginBottom: 15,
    paddingHorizontal: 10,
    width: '100%',
  },
});

export default App;
